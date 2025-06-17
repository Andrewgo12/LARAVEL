<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Usuario</title>
</head>
<body style="margin: 0; padding: 0;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td style="padding: 10px 0 30px 0;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
          <tr>
            <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
              <img src="http://asamblea.valledelcauca.gov.co/info/asamblea/media/pub43460.jpg" width="300" height="230" style="display: block;" alt="Logo" />
            </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                    <b>Usuario Registrado:</b>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                    <ul style="list-style: none; padding-left: 0;">
                      <li style="font-size: 14px;"><strong>Nombre de usuario:</strong> {{ $usuario->username }}</li>
                      <li style="font-size: 14px;"><strong>Email:</strong> {{ $usuario->email }}</li>
                      <li style="font-size: 14px;"><strong>Contraseña:</strong> {{ $password }}</li>
                      <li style="font-size: 14px;"><strong>Centro de costo:</strong> {{ $usuario->centro }}</li>
                      <li style="font-size: 14px;"><strong>Activar cuenta:</strong>
                        <a href="{{ asset('Cauth/activate/' . $usuario->id . '/' . $usuario->code) }}" style="color: #007bff; text-decoration: none;">Haz clic aquí</a>
                      </li>
                    </ul>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
              &reg; Electromedicina, 2019<br/>
              Hospital Universitario E.S.E
            </td>
            <td align="right" width="25%">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <a href="http://www.twitter.com/">
                      <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                    </a>
                  </td>
                  <td width="20"></td>
                  <td>
                    <a href="http://www.fb.com/">
                      <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                    </a>
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
