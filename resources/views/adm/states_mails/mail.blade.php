<html>
    <head>
        <title>Lunelli Carreiras</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style type="text/css">
        #outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
        body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
        body{-webkit-text-size-adjust:none; -ms-text-size-adjust:none; text-size-adjust:none;} /* Prevent Webkit and Windows Mobile platforms from changing default font sizes. */
        body{margin:0; padding:0;}
        img{height:auto; line-height:100%; outline:none; text-decoration:none;-ms-interpolation-mode:bicubic;display:block;}
        #backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
        table{mso-table-lspace:0pt; mso-table-rspace:0pt;}
        </style>
    </head>
    <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td height="30" bgcolor="#fff">&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="500" border="0" align="center"  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;font-size:1.3em;color:{{$data->header_fontcolor}};line-height:1.4;background-color:{{$data->header_background}};">
                            <tbody>
                                <tr>
                                    <td width="435" valign="top" style='padding:5px;'>
                                        @if ($data->header_type=='image')
                                            <img src="{{'https://lunellicarreiras.com.br/'.$data->header_value}}" width="500">
                                        @else
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        {!! str_replace(["\n","\r"],"</tr><tr>",$data->header_value) !!}
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="30">&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="500" border="0" align="center" bgcolor="{{$data->body_background}}" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;font-size:1.3em;color:{{$data->body_fontcolor}};line-height:1.4;background-color:{{$data->body_background}};">
                            <tbody>
                                <tr>
                                    <td width="435" valign="top" style='padding:5px;'>
                                        @if ($data->body_type=='image')
                                            <img src="{{'https://lunellicarreiras.com.br/'.$data->body_value}}" width="500">
                                        @else   
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        {!! str_replace(["\n","\r"],"</tr><tr>",$data->body_value) !!}
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="40">&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="500" border="0" align="center" bgcolor="{{$data->footer_background}}" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;font-size:.7em;color:{{$data->footer_fontcolor}};line-height:1.4;background-color:{{$data->footer_background}};">
                            <tbody>
                                <tr>
                                    <td width="435" valign="top" style='padding:5px;'>
                                        @if ($data->footer_type=='image')
                                            <img src="{{'https://lunellicarreiras.com.br/'.$data->footer_value}}" alt="" width="500" >
                                        @else
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        {!! str_replace(["\n","\r"],"</tr><tr>",$data->footer_value) !!}
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="30" bgcolor="#fff">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>