<?php
class SpotPopularityUpdateShell extends AppShell {
	public $uses = array('Spot');
	
	/**
	 * Calculate new popularity score for all spots and save new scores.  No reviews leads to an average popularity.
	 */
	public function main() {
		$spots = $this->Spot->find('all');
		$avg_rating = $this->Spot->get_avg_rating();
		$avg_rating_count = $this->Spot->get_avg_rating_count();
		
		$func = function($value) {
			
		};
		
		$new_pop_spots = array();
		foreach($spots as $spot) {
			$new_pop_spots[] = array( 'Spot' => array(
				'id' => $spot['Spot']['id'],
				'popularity_score' => $this->Spot->get_bayesian_average($avg_rating_count, $avg_rating, $spot['Spot']['rating_count'], $spot['Spot']['rating'])
			));
		}
		
		$this->Spot->saveMany($new_pop_spots);
	}
}
