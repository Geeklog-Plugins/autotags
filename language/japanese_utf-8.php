<?php

###############################################################################
# japanese_utf-8.php
# This is the japanese language page for the Geeklog Autotags Plug-in!
#
# Copyright (C) 2006 Joe Mucchiello
# Tranlated by Ivy (Geeklog Japanese)
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################


$LANG_AUTO = array(
    'newpage' => '新規ページ',
    'adminhome' => '管理者HOME',
    'tag' => 'タグ名（英数字）',
    'autotag' => 'Autotag',
    'desc' => 'タグの説明',
    'replacement' => '置換文字列',
    'enabled' => '有効:',
    'close_tag' => 'Requires Close Tag?',
    'function' => 'PHPで置換:',
    'short_function' => '関数',
    'autotagseditor' => '自動タグエディター',
    'autotagsmanager' => '自動タグマネージャ',
    'list_of_autotags' => 'List of Autotags',
    'edit' => '編集',
    'save' => '保存',
    'delete' => '削除',
    'cancel' => 'キャンセル',
    
    'access_denied' => 'アクセスが拒否されました。',
    'access_denied_msg' => '自動タグプラグインの管理者用ページに不正にアクセスしています。このアクセスは記録されますので、ご了承ください。',
    'deny_msg' => 'このページへのアクセスが拒否されました。ページが削除あるいはリネームされたのかも知れませんし、またはアクセス権がないのかもしれません。',

    'php_msg_enabled' => 'これをチェックすると、＜phpautotags_タグ名＞という名前の関数が呼び出されて、タグを置換します。PHPにチェックを入れ、<b>置換文字列</b>を指定すると、PHPのコードとして評価されます。コード内では、$p1に第1引数、$p2に第2引数、$tagstrにタグ全体が代入されます。自動タグと置換する文字列を返すにはreturn文を使います。',
    'php_msg_disabled' => 'タグを置換するための関数を呼び出す自動タグを編集するには、コンフィギュレーションで「PHPを許可する」を「はい」にし、さらに autotags.PHP権限をグループに与える必要があります。',
    
    'disallowed_tag' => '選択したタグは使えません。他を選んでください。',
    'duplicate_tag' => '選択したタグはすでに使用されています。他のタグを選ぶか、使用中のタグを編集してください。',
    'no_tag_or_replacement' => '<b>タグ</b>と<b>置換文字列</b>フィールドは必ず入力してください。',
    'invalid_tag' => 'The tag must contain only alphanumeric characters (a-z, A-Z, 0-9).',

    'instructions' => '<p>自動タグの編集・削除は、タグの編集アイコンをクリックしてください。新規作成は、上の"新規作成"をクリックしてください。編集できないか、有効にできないタグがある場合は、それらは関数ベースのタグであり、あなたに autotags.PHP権限がないか、コンフィギュレーションで「PHPを許可する」を「いいえ」にしているため、関数ベースの自動タグが無効になっています。</p>',
    'replace_explain' => '自動タグの記述形式は <b>[tag:parameter1 parameter2]</b> です。<br' . XHTML . '>置換文字列フィールドにはHTMLを記述できます。<br' . XHTML . '>置換文字列フィールドの文字列中に <b>#1</b> や <b>#2</b> を記述することにより、<b>parameter1</b> や <b>parameter2</b> を含めることができます。</p>'
                        .'<p>自動タグは、一般的にリンクを作成するために使用されます。<br' . XHTML . '>タグ <b>[tag:foo This is a link]</b> が、置換文字列フィールドの文字列<br' . XHTML . '> <b>&lt;a href="http://path.to.somewhere/#1"&gt;#2&lt;/a&gt;</b> <br' . XHTML . '>に関連付けられているとき、そのタグは文字列<br' . XHTML . '> <b>&lt;a href="http://path.to.somewhere/foo"&gt;This is a link&lt;/a&gt;</b><br' . XHTML . '>に置換されます。</p>'
                        . '<p>#1 と #2 に加えて、<b>#0</b> は最初のコロンの後の全文字列です。 <b>#U</b> はサイトのベースURLです。</p>',

    'php_not_activated' => '自動タグでPHPが有効になっていません。コンフィギュレーションを確認してください。',

    'edit' => '編集',

    'search' => '検索',
    'submit' => '投稿',
    
    'usagepermissionskey' => 'U = 使用法',
    
    'window_close' => 'クローズ',
    'main_menulabel' => '自動タグ一覧',
);

// Localization of the Admin Configuration UI
$LANG_configsections['autotags'] = array(
    'label' => '自動タグ',
    'title' => '自動タグの設定'
);

$LANG_confignames['autotags'] = array(
    'link_in_menu' => '自動タグをメニューに表示する',
    'disallow' => '使用できない自動タグ名',
    'allow_php' => 'PHPを許可する',
    'default_autotag_permissions' => 'デフォルトのパーミッション'
);

$LANG_configsubgroups['autotags'] = array(
    'sg_main' => '主要設定'
);

$LANG_tab['autotags'] = array(
    'tab_main' => '自動タグの主要設定',
    'tab_autotag_permissions' => '自動タグ使用時のパーミッション'
);

$LANG_fs['autotags'] = array(
    'fs_main' => '自動タグの主要設定',
    'fs_autotag_permissions' => '自動タグ使用時のパーミッション'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['autotags'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => TRUE, 'いいえ' => FALSE),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3),
    13 => array('アクセス不可' => 0, '利用する' => 2)
);

?>