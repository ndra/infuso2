<?

namespace Infuso\Site\Controller;
use Infuso\Core\File as File;
use Infuso\Util\Util as Util;
use PHPExcel_Writer_Excel2007 as PHPExcel_Writer_Excel2007;
use PHPExcel as PHPExcel;
use PHPExcel_Style_Border as PHPExcel_Style_Border;
use Infuso\Core;

/**
 * Контроллер экспорта списка пользователей в excel файл
 **/
class ExportMembersToExcell extends Core\Controller implements Core\Handler {

	public function indexTest() {
	    if(!service("user")->active()->checkAccess("admin:showInterface")) {
            \Infuso\CMS\Admin\Admin::fuckoff();      
        }
        return true;
	}
	
	public function postTest() {
        return true;
	}
    
    public static function index() {
         app()->tm("/site/admin/exportMembersToExcell")
            ->exec();
	}


     /**
     * Создаем excel файл со списком пользователей.
     * Смотрим есть ли пользователи, зарегистрировавшиеся на окрытые даты и которые еще не экспортировались в файл
     **/
    public static function post_create($p) {
        
        $items = \Infuso\Site\Model\Member::all()->eq("type", \Infuso\Site\Model\Member::TYPE_OPENDATE)->eq("exported", false);
        
        if($items->count() > 0){
            $objWriter = new PHPExcel_Writer_Excel2007(self::asExel($items));
            $tmpPath = Core\File::mkdir("/bundles/site/res/membersFile");
            $tmpName = "";
            $tmpName .= date('H:i:s')." ".Util::id().".xlsx";
            $objWriter->save(File::get($tmpPath."/".$tmpName)->native()); //сохраняем репорт на диск
            $fileUrl = File::get($tmpPath."/".$tmpName);
            return $fileUrl;
        }
    }
	
	function numberToColumnName($number){
        $abc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $abc_len = strlen($abc);

        $result_len = 1; // how much characters the column's name will have
        $pow = 0;
        while( ( $pow += pow($abc_len, $result_len) ) < $number ){
            $result_len++;
        }

        $result = "";
        $next = false;
        // add each character to the result...
        for($i = 1; $i<=$result_len; $i++){
            $index = ($number % $abc_len) - 1; // calculate the module

            // sometimes the index should be decreased by 1
            if( $next || $next = false ){
                $index--;
            }

            // this is the point that will be calculated in the next iteration
            $number = floor($number / strlen($abc));

            // if the index is negative, convert it to positive
            if( $next = ($index < 0) ) {
                $index = $abc_len + $index;
            }

            $result = $abc[$index].$result; // concatenate the letter
        }
        return $result;
    }
	
	public function cellIndex($x,$y){
        return self::numberToColumnName($x).($y);
    }
    
    /**
     * Формируем данные excel
     **/
    public function asExel($items) {
        ini_set("memory_limit", "2048M");
        set_time_limit(0);
        $objPHPExcel = new PHPExcel();

        // Set properties

        $objPHPExcel->getProperties()->setCreator("INFUSO Report Generator");
        $objPHPExcel->getProperties()->setLastModifiedBy("INFUSO Report Generator");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Report");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Report");
        $objPHPExcel->getProperties()->setDescription("Office 2007 XLSX Report");


        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $x = 0;
        $y = 0;
        $y++;
        //заполняем отчет данными, прибавляем  индксам 1
        $objPHPExcel->setActiveSheetIndex(0);
        $cellIndex = self::cellIndex(1,$y);
        $objPHPExcel->getActiveSheet()->SetCellValue($cellIndex, "Имя");
        $cellIndex = self::cellIndex(2,$y);
        $objPHPExcel->getActiveSheet()->SetCellValue($cellIndex, "Телефон");
        $cellIndex = self::cellIndex(3,$y);
        $objPHPExcel->getActiveSheet()->SetCellValue($cellIndex, "Email");
        
        foreach($items  as $item) {
            
            //ставим отметку что пользователь экспортирован в файл
            $item->data("exported", true);
            
            $y++;
            $cellIndex = self::cellIndex(1,$y);
            $objPHPExcel->getActiveSheet()->SetCellValue($cellIndex, $item->data("name"));
            $cellIndex = self::cellIndex(2,$y);
            $objPHPExcel->getActiveSheet()->SetCellValue($cellIndex, $item->data("phone"));
            $cellIndex = self::cellIndex(3,$y);
            $objPHPExcel->getActiveSheet()->SetCellValue($cellIndex, $item->data("email"));
        }
        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle("Выгрузка данных");

        return $objPHPExcel;
    }
    
    /**
     * @handler = infuso/deploy
     **/         
    public function onInit() {
        service("task")->add(array(
            "class" => get_class(),
            "method" => "deleteFiles",
            "crontab" => "0 * * * *",
            "randomize" => 180,
            "title" => "Удаление excel файлов со списком пользователей",
        ));
    }
    
    /**
     * Очищаем файлы из папки
     **/
    public static function deleteFiles() {
      Core\File::get("/bundles/site/res/membersFile/")->delete(true);
    }
}
