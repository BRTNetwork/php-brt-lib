<?php

namespace BRTNetwork\BRTLib\Transaction;

use Exception;
use BRTNetwork\Buffer\Buffer;
use BRTNetwork\BRTBinaryCodec\BRTBinaryCodec;
use BRTNetwork\BRTKeypairs\BRTKeypairs;

define('TRANSACTION_ID', 0x54584e00); // 'TXN'

class Sign
{
    private $keypair;
    /**
     * @var BRTKeypairs
     */
    private $binaryCodec;

    public function __construct()
    {
        $this->keypair     = new BRTKeypairs();
        $this->binaryCodec = new BRTBinaryCodec();
    }

    public function sign($txJson, $secret, $options = [])
    {
        return $this->signWithKeypair($txJson, $this->keypair->deriveKeypair($secret), $options);
    }

    public function signWithKeypair($txJson, $keypair, $options)
    {
        if (isset($txJson['TxnSignature']) || isset($txJson['Signers']))
        {
            throw new Exception('txJSON must not contain "TxnSignature" or "Signers" properties');
        }

        //fee checking moved to API.php
        //$this->checkFee($txJson['fee']);

        $txToSignAndEncode                  = $txJson;
        $txToSignAndEncode['SigningPubKey'] = isset($options['signAs']) ? '' : $keypair['public'];

        if (isset($options['signAs']))
        {
            $signer['Account']            = $options['signAs'];
            $signer['SigningPubKey']      = $keypair['public'];
            $signer['TxnSignature']       = $this->computeSignature(
                $txToSignAndEncode,
                $keypair['private'],
                $options['signAs']
            );
            $txToSignAndEncode['Signers'] = [['Signer' => $signer]];
        }
        else
        {
            $txToSignAndEncode['TxnSignature'] = $this->computeSignature(
                $txToSignAndEncode,
                $keypair['private']
            );
        }

        $serialized = $this->binaryCodec->encode($txToSignAndEncode);

        return [
            'signedTransaction' => $serialized,
            'id'                => $this->computeBinaryTransactionHash($serialized)
        ];
    }

    public function computeSignature(array $tx, string $privateKey, string $signAs = null)
    {
        $signingData = $signAs
            ? $this->binaryCodec->encodeForMultisigning($tx, $signAs)
            : $this->binaryCodec->encodeForSigning($tx);

        return $this->keypair->sign(Buffer::hex($signingData)
                                          ->getBinary(), $privateKey);
    }

    public function computeBinaryTransactionHash(string $serializedTx)
    {
        $prefix = Buffer::int(TRANSACTION_ID)
                        ->getHex()
        ;

        return Buffer::hex(hash('sha512', Buffer::hex($prefix . $serializedTx)
                                                ->getBinary()))
                     ->slice(0, 32)
                     ->getHex()
            ;
    }
}
