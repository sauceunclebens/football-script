<?php
//read full .aspx
$url = 'http://xml.pinnaclesports.com/pinnacleFeed.aspx';
$contents = htmlspecialchars_decode(htmlentities(file_get_contents($url)));
//echo $contents;
//$contents = file_get_contents('football.txt');
//echo $contents."<br>"."<br>";
preg_match_all("/<event>\s*<event_datetimeGMT>\s*[0-9]{4,}\s*-\s*[0-9]{2,}\s*-\s*[0-9]{2,}\s+[0-9]{2,}:[0-9]{2,}\s*<\/event_datetimeGMT>\s*<gamenumber>\s*[0-9]{9,}\s*<\/gamenumber>\s*<sporttype>\s*Football.+?<\/event>/is", $contents, $matches); // regular expression

	//values refresh
	//<event> values
	$event_datetimeGMT = "N/A";
	$gamenumber = "N/A";
	$sporttype = "N/A";
	$league = "N/A";
	$IsLive = "N/A";
	$contest_maximum = "N/A";
	$description = "N/A";
	// <participants><participant>
	$participant_name = "N/A";
	$contestantnum = "N/A";
	$rotnum = "N/A";
	$visiting_home_draw = "N/A";
	// <participants><participant><odds>
	$moneyline_value = "N/A";
	$to_base = "N/A";
	// </odds></participant>
	// <periods><period>
	$period_number = "N/A";
	$period_description = "N/A";
	$periodcutoff_datetimeGMT = "N/A";
	$period_status = "N/A";
	$period_update = "N/A";
	$spread_maximum = "N/A";
	$moneyline_maximum = "N/A";
	$total_maximum = "N/A";
	// <moneyline>
	$moneyline_visiting = "N/A";
	$moneyline_home = "N/A";
	$moneyline_draw = "N/A";
	// </moneyline>
	// <periods><period><spread>
	$spread_visiting = "N/A";
	$spread_adjust_visiting = "N/A";
	$spread_home = "N/A";
	$spread_adjust_home = "N/A";
	// </spread>
	// <total>
	$period_total_points = "N/A";
	$period_over_adjust = "N/A";
	$period_under_adjust = "N/A";
	// </total></period>
	// <total>
	$total_points = "N/A";
	$units = "N/A";

for($i=0; $i<count($matches[0]); $i++) {
	//<event> values
	preg_match("/<event_datetimeGMT>\s*([0-9]{4,}\s*-\s*[0-9]{2,}\s*-\s*[0-9]{2,}\s+[0-9]{2,}:[0-9]{2,}?)\s*<\/event_datetimeGMT>/i", $matches[0][$i], $event_datetimeGMT);
	preg_match("/<gamenumber>\s*([0-9]{9,}?)\s*<\/gamenumber>/i", $matches[0][$i], $gamenumber);
	preg_match("/<sporttype>\s*(.*?)\s*<\/sporttype>/i", $matches[0][$i], $sporttype);
	preg_match("/<league>\s*(.*?)\s*<\/league>/is", $matches[0][$i], $league);
	preg_match("/<IsLive>\s*((Yes|No)?)\s*<\/IsLive>/i", $matches[0][$i], $IsLive);
	preg_match("/<contest_maximum>\s*(\d*?)\s*<\/contest_maximum>/i", $matches[0][$i], $contest_maximum);
	preg_match("/<description>\s*(.*?)\s*<\/description>/is", $matches[0][$i], $description);

	$all[$i] = array ("event_datetimeGMT"=>$event_datetimeGMT[1], "gamenumber"=>$gamenumber[1], "sporttype"=>$sporttype[1], "league"=>$league[1], "IsLive"=>$IsLive[1], "contest_maximum"=>$contest_maximum[1], "description"=>$description[1]);

	// regular expression that determinates all invoices of tag <participants>
	preg_match_all("/<participant>.+?<\/participant>/is", $matches[0][$i], $participants);

	for($j=0; $j<count($participants[0]); $j++) {
		// <participants><participant>
		preg_match("/<participant_name>\s*(.*?)\s*<\/participant_name>/is", $participants[0][$j], $participant_name);
		$all[$i]["participant_name_".$j] = $participant_name[1];
		preg_match("/<contestantnum>\s*(.*?)\s*<\/contestantnum>/is", $participants[0][$j], $contestantnum);
		$all[$i]["contestantnum_".$j] = $contestantnum[1];
		preg_match("/<rotnum>\s*(.*?)\s*<\/rotnum>/is", $participants[0][$j], $rotnum);
		$all[$i]["rotnum_".$j] = $rotnum[1];
		preg_match("/<visiting_home_draw>\s*((visiting|home|draw)?)\s*<\/visiting_home_draw>/is", $participants[0][$j], $visiting_home_draw);
		$all[$i]["visiting_home_draw_".$j] = $visiting_home_draw[1];
		// <participants><participant><odds>
		preg_match("/<moneyline_value>\s*(.*?)\s*<\/moneyline_value>/is", $participants[0][$j], $moneyline_value);
		$all[$i]["moneyline_value_".$j] = $moneyline_value[1];
		preg_match("/<to_base>\s*(.*?)\s*<\/to_base>/is", $participants[0][$j], $to_base);
		$all[$i]["to_base_".$j] = $to_base[1];

		//echo $all[0]["to_base_".$j];
	}

	// regular expression that determinates all invoices of tag <period>
	preg_match_all("/<period>.+?<\/period>/is", $matches[0][$i], $periods);

	for($j=0; $j<count($periods[0]); $j++) {
		// <periods><period>
		preg_match("/<period_number>\s*(.*?)\s*<\/period_number>/is", $periods[0][$j], $period_number);
		$all[$i]["period_number_".$j] = $period_number[1];
		preg_match("/<period_description>\s*(.*?)\s*<\/period_description>/is", $periods[0][$j], $period_description);
		$all[$i]["period_description_".$j] = $period_description[1];
		preg_match("/<periodcutoff_datetimeGMT>\s*(.*?)\s*<\/periodcutoff_datetimeGMT>/is", $periods[0][$j], $periodcutoff_datetimeGMT);
		$all[$i]["periodcutoff_datetimeGMT_".$j] = $periodcutoff_datetimeGMT[1];
		preg_match("/<period_status>\s*(.*?)\s*<\/period_status>/is", $periods[0][$j], $period_status);
		$all[$i]["period_status_".$j] = $period_status[1];
		preg_match("/<period_update>\s*(.*?)\s*<\/period_update>/is", $periods[0][$j], $period_update);
		$all[$i]["period_update_".$j] = $period_update[1];
		preg_match("/<spread_maximum>\s*(\d*?)\s*<\/spread_maximum>/is", $periods[0][$j], $spread_maximum);
		$all[$i]["spread_maximum_".$j] = $spread_maximum[1];
		preg_match("/<moneyline_maximum>\s*(\d*?)\s*<\/moneyline_maximum>/is", $periods[0][$j], $moneyline_maximum);
		$all[$i]["moneyline_maximum_".$j] = $moneyline_maximum[1];
		preg_match("/<total_maximum>\s*(\d*?)\s*<\/total_maximum>/is", $periods[0][$j], $total_maximum);
		$all[$i]["total_maximum_".$j] = $total_maximum[1];
		// <moneyline>
		preg_match("/<moneyline_visiting>\s*(\d*?)\s*<\/moneyline_visiting>/is", $periods[0][$j], $moneyline_visiting);
		$all[$i]["moneyline_visiting_".$j] = $moneyline_visiting[1];
		preg_match("/<moneyline_home>\s*(\d*?)\s*<\/moneyline_home>/is", $periods[0][$j], $moneyline_home);
		$all[$i]["moneyline_home_".$j] = $moneyline_home[1];
		preg_match("/<moneyline_draw>\s*(\d*?)\s*<\/moneyline_draw>/is", $periods[0][$j], $moneyline_draw);
		$all[$i]["moneyline_draw_".$j] = $moneyline_draw[1];
		// </moneyline>
		// <spread>
		preg_match("/<spread_visiting>\s*(.*?)\s*<\/spread_visiting>/is", $periods[0][$j], $spread_visiting);
		$all[$i]["spread_visiting_".$j] = $spread_visiting[1];
		preg_match("/<spread_adjust_visiting>\s*(.*?)\s*<\/spread_adjust_visiting>/is", $periods[0][$j], $spread_adjust_visiting);
		$all[$i]["spread_adjust_visiting_".$j] = $spread_adjust_visiting[1];
		preg_match("/<spread_home>\s*(.*?)\s*<\/spread_home>/is", $periods[0][$j], $spread_home);
		$all[$i]["spread_home_".$j] = $spread_home[1];
		preg_match("/<spread_adjust_home>\s*(.*?)\s*<\/spread_adjust_home>/is", $periods[0][$j], $spread_adjust_home);
		$all[$i]["spread_adjust_home_".$j] = $spread_adjust_home[1];
		// </spread>
		// <total>
		preg_match("/<period>(.*)<total_points>\s*(.*?)\s*<\/total_points>/is", $periods[0][$j], $period_total_points);
		$all[$i]["period_total_points_".$j] = $period_total_points[2];
		preg_match("/<over_adjust>\s*(.*?)\s*<\/over_adjust>/is", $periods[0][$j], $period_over_adjust);
		$all[$i]["period_over_adjust_".$j] = $period_over_adjust[1];
		preg_match("/<under_adjust>\s*(.*?)\s*<\/under_adjust>/is", $periods[0][$j], $period_under_adjust);
		$all[$i]["period_under_adjust_".$j] = $period_under_adjust[1];
		// </total></period></periods>
		//echo $all[0]["period_under_adjust_".$j];
	}

	// <total>
	preg_match("/<\/participants>\s*<total>\s*<total_points>\s*(.*?)\s*<\/total_points>/is", $matches[0][$i], $total_points);
	$all[$i]["total_points"] = $total_points[1];
	preg_match("/<units>\s*(.*?)\s*<\/units>/is", $matches[0][$i], $units);
	$all[$i]["units"] = $units[1];
	// </total>
	//echo $all[0]["units_".$j];
}
//echo $all[0]["description"];
for ($i=0; $i<count($matches[0]); $i++)
file_put_contents("out\\Result".($i+1).".txt", $all[$i]); // new file creating
echo count($matches[0])."<br>";
print_r ($all);
 $start = microtime(true);
  $sum = 0;
  for ($i = 0; $i < 100000; $i++) $sum += $i;
  echo "Время выполнения скрипта: ".(microtime(true) - $start);

?>