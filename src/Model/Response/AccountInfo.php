<?php
/**
 * User: Lessmore92
 * Date: 1/14/2021
 * Time: 3:24 PM
 */

namespace BRTNetwork\BRTLib\Model\Response;

use BRTNetwork\BRTLib\Foundation\Contracts\ResponseModelInterface;
use BRTNetwork\BRTLib\Foundation\ResponseModel;
use BRTNetwork\BRTLib\Model\Base\Balance;
use BRTNetwork\BRTLib\Utils;

class AccountInfo extends ResponseModel implements ResponseModelInterface
{
    /**
     * @var string
     */
    public $account;
    /**
     * @var Balance
     */
    public $balance;
    /**
     * @var string
     */
    public $flags;
    /**
     * @var
     */
    public $ledgerEntryType;
    public $ownerCount;
    public $previousTxnID;
    public $previousTxnLgrSeq;
    public $sequence;
    public $index;

    public static function fromJson($json)
    {
        $instance                    = new self();
        $instance->account           = Utils::arrayGet($json, 'Account');
        $instance->balance           = Balance::fromDrops(Utils::arrayGet($json, 'Balance', ''));
        $instance->flags             = Utils::arrayGet($json, 'Flags');
        $instance->ledgerEntryType   = Utils::arrayGet($json, 'LedgerEntryType');
        $instance->ownerCount        = Utils::arrayGet($json, 'OwnerCount');
        $instance->previousTxnID     = Utils::arrayGet($json, 'PreviousTxnID');
        $instance->previousTxnLgrSeq = Utils::arrayGet($json, 'PreviousTxnLgrSeq');
        $instance->sequence          = Utils::arrayGet($json, 'Sequence');
        $instance->index             = Utils::arrayGet($json, 'index');

        return $instance;
    }
}
