<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>属性受信の確認ページ</title>
    <style type="text/css">
    body {
        background-color: #FFFFFF;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        text-align:center;
        line-height: 24px;
    }

    h2 {
        color: #FFFFFF;
        font-size: 18px;
    }

    table {
        margin: auto auto;
        border-collapse: collapse;
    }

    body#maintop {
        background-position: 0px 110px;
    }

    #logoA {
        position: absolute;
        left: 20px;
    }

    div#maincenter{
        position: relative;
        top: 85px;
        margin: 0 auto;
        text-align: center;
    }

    div#logincenter{
        text-align: center;
    }

    strong#logintitle {
        font-size: 11px;
        color: #000000;
    }

    strong#loginname {
        font-size: 12px;
        color: #FF0000;
    }

    #main {
        margin: 90px auto;
        color: #333333;
    }

    td,th.chart {
        padding: 8px 15px;
        font-size: 12px;
        border-style: solid;
        border-width: 3px;
        border-collapse: collapse;
        border-color: #006633;
    }

    th.chart {
        background-color: #333333;
        color: #FFFFFF;
    }

    td.chart-key_odd {
        background-color: #CED5AE;
        white-space: nowrap;
    }

    td.chart-value_odd {
        background-color: #EDF5C8;
    }

    td.chart-key_even {
        background-color: #FFFFFF;
        white-space: nowrap;
    }

    td.chart-value_even {
        background-color: #FFFFFF;
    }

    td.chart-key_notreceived {
        background-color: #c0c0c0;
        white-space: nowrap;
    }

    td.chart-value_notreceived {
        background-color: #c0c0c0;
        white-space: nowrap;
    }

    p.message_notice {
        color: #FF8C00;
        font-weight: bold;
    }
    
    p.message_warning {
        color: #FF0000;
        font-weight: bold;
    }
    </style>
  </head>
  <body id="maintop">
    <div id="maincenter">
      <strong id="logintitle">属性受信の確認ページ</strong><br>
<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE);
print "      <strong id='loginname'>あなたのIdPは、&lt;" . htmlspecialchars($_SERVER['Shib-Identity-Provider']) . "&gt;です。</strong>";
?>
      <br>
    </div>

    <table id="main" cellspacing="0">
      <colgroup>
        <col width="280">
        <col width="420" valign="top">
      </colgroup>
      <thead>
      <tr>
        <th scope="col" class="chart">属性</th>
        <th scope="col" class="chart">属性値</th>
      </tr>
      </thead>
      <tbody>
<?php

    function normal_value($attr_value = ''){
    }

    function notice_value($attr_value = ''){
        if (strpos($attr_value, '\;') !== FALSE)
            print '<p class="message_notice">注意：属性値にセミコロンが含まれているためSPによっては正しく動作しない可能性があります</p>';
    }

    function warning_value($attr_value = ''){
        if (strpos($attr_value, '\;') !== FALSE)
            print '<p class="message_warning">警告：属性値にセミコロンが含まれているため正しくありません</p>';
    }

    $envary = array(
        "eppn"                 => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/eduPersonPrincipalName'>ePPN(eduPersonPrincipalName)</a>"                     , "normal_value"),
        "persistent-id"        => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/eduPersonTargetedID'>eduPersonTargetedID</a>"                                 , "notice_value"),
        "o"                    => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/o'>o(organizationName)</a>"                                                   , "normal_value"),
        "jao"                  => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/jao'>jao(jaOrganizationName)[日本語]</a>"                                     , "normal_value"),
        "ou"                   => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/ou'>ou(organizationalUnitName)</a>"                                           , "normal_value"),
        "jaou"                 => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/jaou'>jaou(jaOrganizationalUnitName)[日本語]</a>"                             , "normal_value"),
        "unscoped-affiliation" => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/eduPersonAffiliation'>職位(eduPersonAffiliation)</a>"                         , "warning_value"),
        "affiliation"          => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/eduPersonScopedAffiliation'>スコープ付き職位(eduPersonScopedAffiliation)</a>" , "warning_value"),
        "entitlement"          => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/eduPersonEntitlement'>権限(eduPersonEntitlement)</a>"                         , "notice_value"),
        "mail"                 => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/mail'>メールアドレス(mail)</a>"                                               , "normal_value"),
        "givenName"            => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/givenName'>名(givenName)</a>"                                                 , "normal_value"),
        "jaGivenName"          => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/jaGivenName'>名(jaGivenName)[日本語]</a>"                                     , "normal_value"),
        "sn"                   => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/sn'>姓(sn)</a>"                                                               , "normal_value"),
        "jasn"                 => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/jasn'>姓(jasn)[日本語]</a>"                                                   , "normal_value"),
        "displayName"          => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/displayName'>表示名(displayName)</a>"                                         , "normal_value"),
        "jaDisplayName"        => array("<a href='https://meatwiki.nii.ac.jp/confluence/display/GakuNinShibInstall/jaDisplayName'>表示名(jaDisplayName)[日本語]</a>"                             , "normal_value"),
    );

    $chart_classes = array(
        array("key" => "chart-key_even", "val" => "chart-value_even"),
        array("key" => "chart-key_odd",  "val" => "chart-value_odd" ),
    );

    $chart_class_notreceived = array(
        "key" => "chart-key_notreceived",
        "val" => "chart-value_notreceived");

    $i = 0;
    foreach ($envary as $attr => $key) {
        list($attr_description, $print_message) = $key;

        if ($i != 0) {
          print "\n";
        }

        $chart_class = $chart_classes[$i % 2];

        if (isset($_SERVER[$attr]) === FALSE) {
            $chart_class = $chart_class_notreceived;
            $val = "NOT RECEIVED";
        } else {
            $val = htmlspecialchars($_SERVER[$attr], ENT_QUOTES, "UTF-8");
        }

        print '        <tr>';
        print '<td class="' . $chart_class["key"] . '" scope="col" nowrap>' . $attr_description . '</td>';
        print '<td class="' . $chart_class["val"] . '">' . $val;
        print $print_message($_SERVER[$attr]) . '</td>';
        print '</tr>';

        $i = $i + 1;
    }
?>       
      </tbody>
    </table>
    <p>現在のセッション情報の詳細はこちらへ。&rArr;<a href="/Shibboleth.sso/Session">セッション情報</a></p>
    <p>このSPに対してログアウトする場合はこちらへ。&rArr;<a href="/Shibboleth.sso/Logout?return=https://<?php print urlencode($_SERVER['HTTP_HOST']) ?>/">ログアウト</a><br>
    (IdPに対してはログインした状態のままになりますのでご注意ください。<br>
    IdPからもログアウトするためにはブラウザを閉じてください)</p>

<?php
    $debug = 0;

    if ($debug > 0) {
        print "    <table>\n";
        while (list($key, $value) = each($_SERVER)) {
            print "      <tr><td>$key</td><td>" . htmlspecialchars($value, ENT_QUOTES, "UTF-8") . "</td>\n";
        }
        print "    </table>\n";
    }
?>

  </body>
</html>
