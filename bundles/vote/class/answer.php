<?

/**
 * Ìîäåëü îòâåòà íà âîïðîñ
 **/
class vote_answer extends reflex {

	

public static function reflex_table() {return array (
  'name' => 'vote_answer',
  'parent' => '',
  'fields' => 
  array (
    0 => 
    array (
      'id' => 'tucv2mnutxfp2rz6w1msrs4d82078u',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '0',
      'label' => '',
      'default' => '',
      'indexEnabled' => '0',
      'help' => '',
    ),
    1 => 
    array (
      'id' => 'q8yvcuokd6ebd39j55bo5lrve9v42x',
      'name' => 'voteID',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '0',
      'label' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'class' => 'vote',
      'collection' => '',
      'titleMethod' => '',
    ),
    2 => 
    array (
      'id' => 'j678s7u77sci0q53ujn1cyl5c1qziq',
      'name' => 'date',
      'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
      'editable' => '2',
      'label' => 'Ð”Ð°Ñ‚Ð° Ð¾Ñ‚Ð²ÐµÑ‚Ð°',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    3 => 
    array (
      'id' => 'e63peixcezowusd8urt4127w5h74g0',
      'name' => 'optionID',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '2',
      'label' => 'Ð”Ð°Ð½Ð½Ñ‹Ðµ Ð³Ð¾Ð»Ð¾ÑÐ¾Ð²Ð°Ð½Ð¸Ñ',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'class' => 'vote_option',
      'collection' => '',
      'titleMethod' => '',
    ),
    4 => 
    array (
      'id' => '10xm12xpe23yvbxkg2dka2o4vhn810',
      'name' => 'cookie',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Ð˜Ð´ÐµÐ½Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚Ð¾Ñ€ cookie Ð¿Ñ€Ð¾Ð³Ð¾Ð»Ð¾ÑÐ¾Ð²Ð°Ð²ÑˆÐµÐ³Ð¾',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'length' => '20',
    ),
  ),
  'indexes' => 
  array (
  ),
);}

public function reflex_beforeCreate() {
	    $this->data("date",util::now());
	}

	public static function all() {
	    return reflex::get(get_class())->desc("date");
	}

	public static function get($id) {
	    return reflex::get(get_class(),$id);
	}

	public function reflex_parent() {
		return vote::get($this->data("voteID"));
	}

	public function reflex_cleanup() {
		return !$this->reflex_parent()->exists();
	}

	/**
	 * @return Âàðèàíò îòâåòà
	 **/
	public function option() {
		return $this->pdata("optionID");
	}

	/**
	 * @return Îáúåêò ãîëîñîâàíèÿ
	 **/
	public function vote() {
		return $this->pdata("voteID");
	}

	public function reflex_afterOperation() {
		mod::fire("vote_answersChanged",array(
		    "vote" => $this->vote(),
		    "answer" => $this,
		    "option" => $this->option(),
		));
	}

}
