<?php
define('CONSTANT', 'c');

class MyClass extends YourClass
{

	protected $_local_variable = array(
		"key" => 1,
		"key2" => array(
			"key" => 2
		)
	);

	public function __construct()
	{
		
	}

	/**
	 *
	 * @global type $DATA 
	 */
	public function render_personen()
	{
		global $DATA;

		$DATA['achternaam'] = 'Meijer';

		$query = $queries['example'] = "
			SELECT
				id,
				voornaam
			FROM 
				personen
			INNER JOIN 
				bedrijven ON personen.bedrijf_id = bedrijf.id
			WHERE
				personen.achternaam LIKE '" . mysql_escape_string($DATA['achternaam']) . "%'
		";

		$query_result = mysql_query($query);
		?>
		<script type="text/javascript">
			// JSlint
			var eenPersoon = true;
			function meerderePersonen() { 
				"use strict";
				return false;
			}
		</script>
		<table>
			<?php
			while ($persoon = mysql_fetch_assoc($query_result)) {
				?>
				<tr>
					<td><?= htmlentities($persoon['voornaam']); ?></td>
				</tr>
				<?php
			}
			?>
		</table>
		<?php
	}

}