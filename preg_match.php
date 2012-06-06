<?php

var_dump(preg_match("/^\w+$/", "ab09__00"));

preg_match('/(column)[@\.#]([^\/]+)(\/|$)/', "column@state/column", $matches);

var_dump($matches);

$html ='
		<foreach variable="fff">
			<h1>??</h1>
		</foreach>
		';
$html = preg_replace_callback('/\<(?P<tag>foreach)(?P<attributes_raw>(\s+(?:\w+=(?:\w|"[^"]*")))+)?\s*\>(?P<content>.*(?!\<\1))\<\/\1\>/s', function(array $match) {
echo 'ff';
	var_dump($match);
	return '';
}, $html);

preg_match("/(?<options>[^\w]+)?(" . preg_quote("inactief") . ")(@(?<state>[^\/]+))?(\/|$)/", "inactief", $property_matches);
var_dump($property_matches);

echo 'fff';
$content = 'In dit traject is een opleidingsplan is een hulpmiddel om het competentieniveau van uw afdeling te bepalen en, waar nodig, te verbeteren.
<ol>
%%%punt 1
%%%punt 2
%%%punt 3
</ol>
<ul>
%%%punt 1
%%%punt 2
%%%punt 3
</ul>';
preg_replace_callback('/\<(?P<tag>\w+)(?P<attributes_raw>(\s+(?:\w+=(?:\w|"[^"]*")))+)?\s*\>(?P<content>((?!\<\1).)*)\<\/\1\>/s', function($match) {
	var_Dump($match);
	
	$attributes = array();
	if (isset($match['attributes_raw'])) {
		preg_match_all('/\s+((?<name>\w+)=(?P<value>\w+|"[^"]*"))?/', $match['attributes_raw'], $attribute_matches, PREG_SET_ORDER);
		var_dump($attribute_matches);
		foreach ($attribute_matches as $attribute_match) {
			$attributes[$attribute_match['name']] = trim($attribute_match['value'], '"');
		}
	}
	
	var_Dump($attributes);
}, $content);

$text = 'te';