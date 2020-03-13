<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>PEDMAP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body style="margin: 0; padding: 0;">

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background: #005CAA;border-top:5px solid #4D4B50; border-bottom:5px solid #4D4B50;">
    <tr>
        <td>

            <table align="center" border="0" cellpadding="0" cellspacing="0" width="500" style="border-collapse: collapse;">
                <tr>
                    <td style="padding:69px 39px;    padding-top: 81px;">

                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-radius:6px;overflow:hidden;    box-shadow: 0px 0px 5px #35353575;">
                            <tr>
                                <td align="center" bgcolor="#ffffff" style="padding: 14px;">

                                    <a href="http://pedmap.com.br/" target="_blank">
                                        <img src="https://imgur.com/BN2FY7q.png" style="width: 170px;" />
                                    </a>

                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#ffffff" style="     color: black;     font-family: sans-serif;     font-size: 15px;     font-weight: bold;     padding: 10px 25px;     padding-top: 15px; ">

                                    Olá, {{ $user->nome }}.

                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#ffffff" style="     color: #656565;     font-family: sans-serif;     font-size: 14px;     font-weight: normal;     padding: 0px 25px;     padding-top:3px;     padding-bottom: 10px;">

                                    Esqueceu a sua senha? Não tem problema.

                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#ffffff" style="    color: #656565;     font-family: sans-serif;     font-size: 14px;     font-weight: normal;     padding: 0px 25px;     padding-top: 0px;     padding-bottom: 11px;">

                                    Crie uma nova clicando no botão abaixo:

                                </td>
                            </tr>

                            @php 

                                $usuario_master_id = (isset($user->usuario_master_id))?$user->usuario_master_id:0;

                            @endphp

                            <tr>
                                <td align="center"bgcolor="#ffffff" style="    padding: 15px 24px; padding-bottom: 21px;">
                                    <a href="{{ env('APP_URL') }}/reset/senha/{{ ($user->senhaHashRecovery) }}?usuario_master_id={{ $usuario_master_id }}&usuario_id={{ $user->id }}" target="_blank" style="    border-radius: 4px;     background: #353535;     padding: 14px;     font-size: 16px;     text-align: center;     display: block;     color: white;     text-decoration: none;     font-family: sans-serif;"> Criar nova senha </a>
                                </td>
                            </tr>
                        </table>

                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="">
                            <tr>
                                <td align="center" style="padding: 3px; color:white;  font-family: sans-serif;   font-size:12px; padding-top:25px;">

                                    Esta é uma mensagem automatizada. Não responda.

                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding: 3px; color:white;  font-family: sans-serif;   font-size:12px; padding-bottom:25px;">

                                    Caso não visualize as imagens, clique no botão "Mostrar imagens”.

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

</body>

</html>