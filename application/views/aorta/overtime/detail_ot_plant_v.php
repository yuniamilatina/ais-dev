    
        <table class="table table-condensed table-hover display" cellspacing="0" width="50%" style="font-size: 11px;">
            <thead>
                <tr>
                    <td colspan='3' align='center' style="font-weight: bold;">Summary This Periode</td>
                </tr>
            </thead>
                <tr>
                    <td>Total MP</td>
                    <td>:</td>
                    <td><strong><?php echo $detail_quota_plant->KRY ?> MP</strong></td>
                </tr>
                <tr>
                    <td>Quota STD</td>
                    <td>:</td>
                    <td><strong><?php echo number_format($detail_quota_plant->QUOTA_STD,2,',','.'); ?> H</strong></td>
                </tr>
                <tr>
                    <td>Quota Plan</td>
                    <td>:</td>
                    <td><strong><?php echo number_format($detail_quota_plant->QUOTAPLAN,2,',','.'); ?> H</strong></td>
                </tr>
                <tr>
                    <td>Actual OT</td>
                    <td>:</td>
                    <td><strong><?php echo number_format($detail_quota_plant->TERPAKAIPLAN,2,',','.'); ?> H</strong></td>
                </tr>
                <tr>
                    <td>Saldo Quota</td>
                    <td>:</td>
                    <td><strong><?php echo number_format($detail_quota_plant->SISAPLAN,2,',','.'); ?> H</strong></td>
                </tr>
                <tr>
                    <td>Avg Quota (Est 22 WD)</td>
                    <td>:</td>
                    <td><strong><?php echo number_format($detail_quota_plant->AVG_QUOTA,2,',','.'); ?> H/Day</strong></td>
                </tr>
                <tr>
                    <td>Avg OT (Est 22 WD)</td>
                    <td>:</td>
                    <td><strong><?php echo number_format($detail_quota_plant->AVG_OT,2,',','.'); ?> H/Day</strong></td>
                </tr>
                <tr>
                    <td>Avg Saldo (Est 22 WD)</td>
                    <td>:</td>
                    <td><strong><?php echo number_format($detail_quota_plant->AVG_SISA,2,',','.'); ?> H/Day</strong></td>
                </tr>
            <tbody>
                
            </tbody>
        </table>