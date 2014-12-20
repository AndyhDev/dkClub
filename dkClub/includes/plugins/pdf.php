<?php
function plugin_pdf($name){
    if(is_file('pdfs/' . $name)){
        $path = 'pdfs/' . $name;
        $site_mb = round((filesize($path) / 1048576), 2);
        return "<table style='text-align:center;border:0px;' border='0'>
        <tr>
          <td style='width:120px;border:0px;'>
            <a href='index.php?download=$name&amp;type=pdf'><img src='img/pdf_64.png' alt='pdf'/></a>
          </td>
        </tr>
        <tr>
          <td style='border:0px;'>
            Größe: $site_mb mb
          </td>
        </tr>
      </table>";
    }elseif(is_file('intern/pdf/' . $name)){
        if($_SESSION['login'] == 'ok'){
            $path = 'intern/pdf/' . $name;
            $site_mb = round((filesize($path) / 1048576), 2);
            return "<table style='text-align:center;border:0px;' border='0'>
            <tr>
              <td style='width:120px;border:0px;'>
                <a href='index.php?download=$name&amp;type=pdf&amp;intern=yes'><img src='img/pdf_64.png' alt='pdf'/></a>
              </td>
            </tr>
            <tr>
              <td style='border:0px;'>
                Größe: $site_mb mb
              </td>
            </tr>
          </table>";
        }
    }
}
?>
