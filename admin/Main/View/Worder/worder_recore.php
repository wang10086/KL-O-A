<div class="content" style="padding:10px 30px;">
    <table rules="none" border="0">
        <tr>
            <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="160">操作时间</th>
            <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="100">操作人</th>
            <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="500">操作说明</th>
        </tr>
        <foreach name="record" item="v">
            <tr>
                <td style="padding:20px 0 0 0">{$v.time|date='Y-m-d H:i:s',###}</td>
                <td style="padding:20px 0 0 0">{$v.uname}</td>
                <td style="padding:20px 0 0 0">{$v.explain}</td>
            </tr>
        </foreach>
    </table>
</div>