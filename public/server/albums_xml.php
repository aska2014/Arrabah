<?php

header("Content-type: text/xml");

if(!isset($_GET["apppassword"]) && $_GET["apppassword"] != "kareem123")

	exit();

function getBasePath()
{
	$root = $_SERVER["DOCUMENT_ROOT"];
	$pos = strpos($root, "public_html");
	return substr($root, 0, $pos);
}

$exclude = array(".", "..");

$dir = realpath(getBasePath() . "D:/website/arrabah/public/albums");

if(!file_exists($dir))
	exit();

list( $images, $galleries ) = getImagesAndNestedGalleries($dir);

function getImagesAndNestedGalleries( $path )
{
	global $exclude;

	$images    = array();
	$galleries = array();

	foreach (array_diff(scandir( $path ), $exclude) as $file)
	{
		if(preg_match("/(.*).(?:jpe?g|png|gif)/i", $file))

			array_push($images, $file);

		elseif(is_dir($path . "/" . $file))
		{
			list($nestedImages, $nestedGalleries) = getImagesAndNestedGalleries($path . "/" . $file);

			$galleries[] = array(

				"name" => fileName( $file ),

				"images" => $nestedImages,

				"galleries" => $nestedGalleries

			);
		}
	}

	return array($images, $galleries);
}

function fileName( $file )
{
	$info = pathinfo($file);

	return $info["filename"];
}


//echo the XML declaration
echo chr(60).chr(63)."xml version='1.0' encoding='utf-8' ".chr(63).chr(62);

echo "<galleries>";

foreach ($galleries as $gallery)
{	
	echoGallery( $gallery );
}

echo "</galleries>";

function echoGallery( $gallery )
{
	echo "<gallery>";

		echo "<name>" . htmlspecialchars($gallery["name"]) ."</name>";
		echo "<images>";
		foreach ($gallery["images"] as $image)
		{
			echo "<image>".htmlspecialchars($image)."</image>";
		}
		echo "</images>";

		echo "<galleries>";
		foreach ($gallery["galleries"] as $nestedGallery)
		{
			echoGallery($nestedGallery);
		}
		echo "</galleries>";

	echo "</gallery>";
}