<?

class seo_query_engine extends reflex {

	public static function all() { return reflex::get(get_class()); }
	
	public static function get($id) { return reflex::get(get_class(),$id); }
	
	public static function reflex_root() {
		return array(
			self::all()->title("Механизмы поиска")->param("tab","system")
		);
	}
	
}
