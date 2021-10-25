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
                                            @php
                                                $data->header_value='https://www.lunellicarreiras.com.br/'.$data->header_value;
                                            @endphp
                                            <img src="{{$data->header_value}}" width="500" height="200" title='Topo' alt='Lunelli Carreiras'>
                                        @else
                                            <table>
                                                <tbody>
                                                    <tr style='color:{{$data->header_fontcolor}};'>
                                                        @if(!empty($candidate->name))
                                                            @php
                                                                $data->header_value=str_replace("@nome@",$candidate->name,$data->header_value);
                                                            @endphp
                                                        @endif
                                                        @if(!empty($job->name))
                                                            @php
                                                                $data->header_value=str_replace("@vaga@",$job->name,$data->header_value);
                                                            @endphp
                                                        @endif
                                                        @php
                                                            $substitute="</td></tr><tr><td style='color:".$data->header_fontcolor.";'>";
                                                        @endphp
                                                        <td style='color:{{$data->header_fontcolor}};'>
                                                            {!! str_replace(["\n","\r"],$substitute,$data->header_value) !!}
                                                        </td>
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
                                            @php
                                                $data->body_value='https://www.lunellicarreiras.com.br/'.$data->body_value;
                                            @endphp
                                            <img src="{{$data->body_value}}" width="500" height="500" title='Corpo' alt='Lunelli Carreiras'>
                                        @else   
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        @if(!empty($candidate->name))
                                                            @php
                                                                $data->body_value=str_replace("@nome@",$candidate->name,$data->body_value);
                                                            @endphp
                                                        @endif
                                                        @if(!empty($job->name))
                                                            @php
                                                                $data->body_value=str_replace("@vaga@",$job->name,$data->body_value);
                                                            @endphp
                                                        @endif
                                                        @php
                                                            $substitute="</td></tr><tr><td style='color:".$data->body_fontcolor.";'>";
                                                        @endphp
                                                        <td style='color:{{$data->body_fontcolor}};'>
                                                            {!! str_replace(["\n","\r"],$substitute,$data->body_value) !!}
                                                        </td>
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
                        <table width="500" border="0" align="center" bgcolor="{{$data->footer_background}}" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;color:{{$data->footer_fontcolor}};line-height:1.4;background-color:{{$data->footer_background}};">
                            <tbody>
                                <tr>
                                    <td width="435" valign="top" style='padding:5px;'>
                                        @if ($data->footer_type=='image')
                                            @php
                                                $data->footer_value='https://www.lunellicarreiras.com.br/'.$data->footer_value;
                                            @endphp
                                            <img src="{{$data->footer_value}}" alt="" width="500" height="200"  title='Rodapé' alt='Lunelli Carreiras'>
                                        @else
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        @if(!empty($candidate->name))
                                                            @php
                                                                $data->footer_value=str_replace("@nome@",$candidate->name,$data->footer_value);
                                                            @endphp
                                                        @endif
                                                        @if(!empty($job->name))
                                                            @php
                                                                $data->footer_value=str_replace("@vaga@",$job->name,$data->footer_value);
                                                            @endphp
                                                        @endif
                                                        @php
                                                            $substitute="</td></tr><tr><td style='color:".$data->footer_fontcolor.";'>";
                                                        @endphp
                                                        <td style='color:{{$data->footer_fontcolor}};'>
                                                            {!! str_replace(["\n","\r"],$substitute,$data->footer_value) !!}
                                                        </td>
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