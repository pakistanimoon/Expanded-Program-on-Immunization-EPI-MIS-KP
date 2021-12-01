<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">
<Document>
	<name>ictucs.kml</name>
	<StyleMap id="stylemap_id5">
		<Pair>
			<key>normal</key>
			<styleUrl>#style250</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#style90</styleUrl>
		</Pair>
	</StyleMap>
	<Style id="style250">
		<LineStyle>
			<color>ff000000</color>
		</LineStyle>
		<PolyStyle>
			<color>0a7f55ff</color>
		</PolyStyle>
	</Style>
	<Style id="style90">
		<LineStyle>
			<color>ff000000</color>
		</LineStyle>
		<PolyStyle>
			<color>0a7f55ff</color>
		</PolyStyle>
	</Style>
	
	<Folder>
		<name>ICT UCs / Defaulter Childs</name>
		<Placemark>
			<name> UC-<?php echo $row["code"];?></name>
			<description><![CDATA[<table border="1">
<tr>
<td><?php echo "UC"; ?></td><td><?php echo $row["name"]; ?></td>
</tr>
<tr>
<td>District</td><td><?php echo $row["district"]; ?></td>
</tr>
</table>]]></description>
			<styleUrl>#stylemap_id5</styleUrl>
			<MultiGeometry>
				<Polygon>
					<outerBoundaryIs>
						<LinearRing>
							<coordinates>
								<?php echo $row["geo_paths"]; ?>
							</coordinates>
						</LinearRing>
					</outerBoundaryIs>
				</Polygon>
			</MultiGeometry>
		</Placemark>
	</Folder>
</Document>
</kml>
