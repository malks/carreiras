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
        <br><br>
        <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th colspan=2 style='color:#666;'>
                        Mensagem enviada a partir do portal Lunelli Carreiras
                    </th>
                </tr>
                <tr>
                    <th colspan=2  style='color:#666;'>
                        Remetente: {{$contact['contact_name']}} - {{$contact['contact_mail']}}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan=2><hr></td></tr>
                <tr>
                    <td width='10px'></td>
                    <td>
                        <h4>
                            {{$contact['contact_subject']}}
                        </h4>
                    </td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td width='10px'></td>
                    <td>
                        {!!str_replace("\n","<br>",$contact['contact_text'])!!}
                    </td>
                </tr>
                <tr><td><br></td></tr>
                @if(!empty($contact['attachment']))
                    <tr>
                        <td width='10px'></td>
                        <td>
                            <a href="https://lunellicarreiras.com.br/files/{{$contact['attachment']}}">Link para o anexo</a>
                        </td>
                    </tr>
                    <tr><td><br></td></tr>
                @endif
                <tr><td colspan=2><hr><br></td></tr>
                <tr><td colspan=2><hr><br></td></tr>
            </tbody>
        </table>
        <br><br>
    </body>
</html>