<?php 
function email_content($product,$product_id,$pod_size,$pod_image,$pod_short_info,$currency,$c_price,$regular_price, $total,$after_3_month_price, $site_link,$header_logo,$email_contant,$email_footer_content,$email_footer,$email_address,$email_footer_last_column,$email_footer_logo,$insurance_fee,$product_short_description){ 
   
   $content =  '<table width="700" border="0" align="center"
            style="margin:0 auto; border-spacing: 0; font-family:Arial,Verdana,sans-serif;font-size:15px">
        <tbody>
            <tr>
                <td style="font-family:Arial,Verdana,sans-serif">
                    <table width="100%" border="0">
                        <tbody>
                            <tr style="background-color: #1d959f;">
                                <td style="padding: 20px 0 20px 0px;" align="center">
                                    <a href="'.$site_link.'" target="_blank">
                                       
                                        <img src="/wp-content/uploads/2022/12/Ease-the-Squeeze-logo-part-WO.png" alt="" width="170" height="92" class="CToWUd">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td height="20">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="font-family:Arial,Verdana,sans-serif">
                                    '.$email_contant.'
                                </td>
                            </tr>
                            <tr>
                                <td height="20">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="font-family:Arial,Verdana,sans-serif">
                                    <table width="100%" border="0">
                                        <tbody>
                                            <tr>
                                                <td width="240"><img
                                                        src="'.$pod_image['url'].'"
                                                        alt="" width="172" style="margin-bottom:10px" class="CToWUd"
                                                        data-bit="iit">
                                                </td>
                                                <td style="font-family:Arial,Verdana,sans-serif">
                                                    <h2
                                                        style="font-size:35px;margin-bottom:5px;padding:0;line-height:normal;font-family:Arial,Verdana,sans-serif;color:#000">
                                                        '.$pod_size.' - '.$product->name.'</h2>
                                                    <p
                                                        style="font-size:13px;color:#000;margin-bottom:7px;padding:0px;margin-top:0;font-family:Arial,Verdana,sans-serif">
                                                        '.$pod_short_info.'</p>
                                                   
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" height="20"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="min-width:100%;border:1px solid #ffbb75;margin-bottom:6px" width="100%"
                        cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <table
                                        style="min-width:100%;background:#f7a71c;border-bottom:1px solid #f37021;font-family:Arial,Verdana,sans-serif"
                                        width="100%" cellspacing="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td width="1%" colspan="2"
                                                    style="font-size:16px;font-weight:bold;font-family:Arial,Verdana,sans-serif;color:#000;padding:10px 10px 10px 20px">
                                                    <img src="'.$site_link.'/wp-content/uploads/2022/12/white_arrow.png"
                                                        width="15.98" height="15.98" alt=""
                                                        style="vertical-align:middle;display:inline-block;width:16px;"
                                                        class="CToWUd" data-bit="iit">
                                                </td>
                                                <td>
                                                    <strong
                                                        style="color:#fff;margin-left:5px;font-size:16px;font-family:Arial,Verdana,sans-serif">50%
                                                        OFF 12 weeks applied!</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table
                                        style="min-width:100%;background:#f9e9ce;border-bottom:1px solid #ffbb75;font-family:Arial,Verdana,sans-serif"
                                        width="100%" cellspacing="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td width="50%" colspan="2"
                                                    style="min-width:50%;font-size:18px;font-weight:bold;font-family:Arial,Verdana,sans-serif;color:#000;padding:15px 20px">
                                                    Per 4 weeks
                                                </td>
                                                <td width="50%"
                                                    style="min-width:50%;font-size:18px;font-weight:bold;font-family:Arial,Verdana,sans-serif;color:#000;padding:15px 20px;text-align:right">
                                                    '.$currency .$regular_price.'
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:20px 5px 15px">
                                    <table width="100%" border="0" cellspacing="0"
                                        style="min-width:100%;font-family:Arial,Verdana,sans-serif">
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="font-family:Arial,Verdana,sans-serif;color:#000;padding:5px 10px">
                                                    <strong>'.$product->name.'</strong>
                                                    <br><span style="font-size:12px;color:#f7a71c;font-weight:600">'.$product_short_description.'</span>
                                                </td>

                                                <td
                                                    style="font-family:Arial,Verdana,sans-serif;text-align:right;white-space:nowrap;color:#000;padding:5px 10px">
                                                   '.$currency .$regular_price.'

                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="font-family:Arial,Verdana,sans-serif;color:#000;padding:5px 10px">
                                                    <strong>Insurance</strong>
                                                    <br><span style="font-size:12px;color:#f7a71c;font-weight:600">At 0.20% of declared value plus IPT Tax</span>
                                                </td>

                                                <td
                                                    style="font-family:Arial,Verdana,sans-serif;text-align:right;white-space:nowrap;color:#000;padding:5px 10px">
                                                   '.$currency .$insurance_fee.'

                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table style="min-width:100%;border:1px solid #ffbb75;margin-bottom:7px" width="100%"
                        cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <table
                                        style="min-width:100%;background:#f9e9ce;border-bottom:1px solid #ffbb75;font-family:Arial,Verdana,sans-serif"
                                        width="100%" cellspacing="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td width="50%"
                                                    style="min-width:50%;font-size:18px;font-weight:bold;font-family:Arial,Verdana,sans-serif;color:#000;padding:15px 20px">
                                                    One-off
                                                </td>
                                                <td width="50%"
                                                    style="min-width:50%;font-size:18px;font-weight:bold;font-family:Arial,Verdana,sans-serif;color:#000;padding:15px 20px;text-align:right">
                                                    '.$currency .$c_price.'
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:20px 5px 15px">
                                    <table width="100%" border="0" cellspacing="0"
                                        style="min-width:100%;font-family:Arial,Verdana,sans-serif">
                                        <tbody>

                                            <tr>
                                                <td
                                                    style="font-family:Arial,Verdana,sans-serif;color:#000;padding:5px 10px">
                                                    <strong>Collection Services</strong>
                                                </td>
                                                <td
                                                    style="font-family:Arial,Verdana,sans-serif;text-align:right;white-space:nowrap;color:#000;padding:5px 10px">
                                                    '.$currency .$c_price.'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="border-top:0px solid #666;height:8px;padding:0">
                                                    &nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <table style="border-top:1px dotted #666;min-width:100%;width:100%"
                                                        width="100%" border="0">
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="min-width:100%;border:1px solid #ffbb75;margin-bottom:0px" width="100%"
                        cellspacing="0" cellpadding="0" border="0">
                        <tbody>

                            <tr>
                                <td colspan="2">
                                    <table width="100%" style="min-width:100%;background:#f9e9ce;margin:0px"
                                        cellspacing="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td colspan="2" height="25px">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="font-family:Arial,Verdana,sans-serif;font-size:20px;font-weight:bold;padding:0px 20px 15px;border-bottom:1px dotted #333">
                                                    Pay today</td>


                                                <td
                                                    style="font-family:Arial,Verdana,sans-serif;text-align:right;font-size:20px;white-space:nowrap;padding:0px 20px 15px;border-bottom:1px dotted #333">
                                                    <span
                                                        style="width:100px;display:inline-block;font-weight:bold">' .$total.'</span>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding:15px 20px 0px">
                                                    <table width="100%" style="width:100%" cellspacing="0">
                                                        <tbody>
                                                            <tr>
                                                                <td
                                                                    style="font-family:Arial,Verdana,sans-serif;padding:0px 0px 0px 0px">
                                                                    <span>
                                                                        <strong>
                                                                            '.$currency .$after_3_month_price.' per 4 weeks after 12 weeks<br>
                                                                        </strong>
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    style="text-align:right;background:#3aa178;color:#fff;border-radius:6px;border:0px;padding:13px 10px;font-size:17px;text-align:center;font-weight:600;letter-spacing:0.5px;text-decoration:none;width:220px;margin-bottom:5px;font-family:Arial,Verdana,sans-serif">
                                                                    <a style="background:#3aa178;color:#fff;border:0px;display:inline-block;font-size:17px;text-align:center;font-weight:600;letter-spacing:0.5px;text-decoration:none;width:220px;margin-bottom:0;font-family:Arial,Verdana,sans-serif"
                                                                        href="'.$site_link.'/?add-to-cart='.$product_id.'">
                                                                        Complete Booking </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" height="25px">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style=" padding: 0;" height="40">&nbsp;</td>
            </tr>
            <!-- <tr>
                <td colspan="2" style=" padding: 0;">
                    <table width="100%" cellspacing="0" cellpadding="5" border="0">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <h2
                                        style="margin-bottom:0px;font-family:Arial,Verdana,sans-serif;font-size:36px;font-weight:bold;text-align:center;color:#000">
                                        How it Works</h2>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" height="40">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-right:1px solid #ccc;text-align:center">
                                    <img src="https://ocpremiumthemes.com/3dloader/GMS-Move/assets/Images/collact.png"
                                        alt="howitworks_01" style="max-width:100%" class="CToWUd" data-bit="iit">
                                </td>
                                <td style="border-right:1px solid #ccc;text-align:center">
                                    <img src="https://ocpremiumthemes.com/3dloader/GMS-Move/assets/Images/storage.png"
                                        alt="howitworks_01" style="max-width:100%" class="CToWUd" data-bit="iit">
                                </td>
                                <td style="text-align:center">
                                    <img src="https://ocpremiumthemes.com/3dloader/GMS-Move/assets/Images/return.png"
                                        alt="howitworks_01" style="max-width:100%" class="CToWUd" data-bit="iit">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr> -->
            <tr>
                <td style="padding: 0;" colspan="2" height="30">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style=" padding: 0 0 0 0px;">
                    '.$email_footer_content.'
                </td>
            </tr>
          
            <tr>
                <td colspan="2" style="border: 1px solid #ffbb75; padding: 0;">
                    <table border="0" style="font-size:14px;min-width: 100%;border-spacing: 0;">
                        <tbody style="border-spacing: 0;">
                            <tr>
                                <td
                                    style="font-family:Arial,Verdana,sans-serif;padding:18px 10px;background:#f9e9ce;width:200px">
                                    '.$email_footer.'
                                </td>
                                <td style="font-family:Arial,Verdana,sans-serif;padding:18px 10px;color:#000">
                                    '.$email_address.'
                                </td>
                                <td
                                    style="font-family:Arial,Verdana,sans-serif;text-align:right;padding:18px 10px;background:#f9e9ce;width:200px;color:#000">
                                    '.$email_footer_last_column.'
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
            <td colspan="2" height="20" style="padding: 0;">
                <a href="#" target="_blank">
                
                    <img src="/wp-content/uploads/2022/12/box.png" width="100%"
                        alt="refer-a-friend" class="CToWUd" data-bit="iit"></a>
            </td>
        </tr>
            
            
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>';
    return $content;

}