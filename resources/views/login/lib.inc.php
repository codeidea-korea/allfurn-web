<?
header('Content-Type: text/html; charset=utf-8');
/*
 * 관리자 페이지, 사이트 페이지 공통
*/

//0. ini_set Session time
//ini_set('session.gc_maxlifetime',86400);
//ini_set('session.cookie_lifetime',86400);
//ini_set('session.cache_expire',1440);

// 1. Session Class
include_once ("PEAR.php");
include_once ("HTTP/Session.php");

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);

HTTP_Session::useCookies(true);
HTTP_Session::start('SESS_SITE', uniqid('SiteID'));
//HTTP_Session::setExpire(time()+60*60*2);		// 9 hour
//HTTP_Session::setIdle(60*60*2);		//  2 hour

// 2. Template Class
include_once "Template_API.class.php";

$_TPL = new Template_API();
// 3. DB Class
include_once "DB.php";

$_DB = DB::connect("pgsql://$_DB_ID:$_DB_PWD@52.79.116.44/$_DB_NAME");
$REQUEST_URI = $PHP_SELF;

if(HTTP_Session::get('_MEMB_ID')){
	if(HTTP_Session::get('_MEMB_ONLINE')=="Y"){
		$_USE = $_DB->getOne(" select case when count(*) > 0 then 'Y' else 'N' end from study_list where status = 'C' and ( to_timestamp(now(),'YYYY-MM-DD') between start_date and end_date ) and memb_id = ? ",HTTP_Session::get('_MEMB_ID'));
	}else{
		$_USE = "Y"; // 로그인 했으면서 기존 회원이면 유료회원이다.
	}
	$_flash_log = 2;
}else{
	$_USE = "N"; // 로그인 하지 않았으면 유료컨텐츠 이용이 불가능하다.
	$_flash_log = 1;
}


// 2008-07-25 오전 11:34:42
// 상단 플레쉬 통합작업
$__memb_class = HTTP_Session::get('_MEMB_CLASS');

// 메인 페이지
if (_MENU=='index') {
			switch ($__memb_class) {
			case "1":$menu_swf = "/fla_new/main_180130.swf?memb=4&log=".$_flash_log;break;
			case "2":$menu_swf = "/fla_new/main_180130.swf?memb=3&log=".$_flash_log;break;
			case "3":$menu_swf = "/fla_new/main_180130.swf?memb=2&log=".$_flash_log;break;
			case "4":$menu_swf = "/fla_new/main_180130.swf?memb=1&log=".$_flash_log;break;
			default:$menu_swf  = "/fla_new/main_180130.swf?memb=2&log=".$_flash_log;break;
			/*
			case "1":$menu_swf = "images/main_office/fla/main_4.swf";break;
			case "2":$menu_swf = "images/local_office/fla/main_3.swf";break;
			case "3":$menu_swf = "images/ga_office/fla/main_2.swf";break;
			case "4":$menu_swf = "images/ga_office/fla/main_1.swf";break;
			default:$menu_swf  = "images/ga_office/fla/main_2.swf";break;
			*/
		}
} else if (_MENU=='cat_01') {// 암산셈 교육
			switch ($__memb_class) {
			case "1":$menu_swf = "/fla_new/sub_01_1.swf?memb=4&log=".$_flash_log;break;
			case "2":$menu_swf = "/fla_new/sub_01_1.swf?memb=3&log=".$_flash_log;break;
			case "3":$menu_swf = "/fla_new/sub_01_1.swf?memb=2&log=".$_flash_log;break;
			case "4":$menu_swf = "/fla_new/sub_01_1.swf?memb=1&log=".$_flash_log;break;
			default:$menu_swf  = "/fla_new/sub_01_1.swf?memb=2&log=".$_flash_log;break;
			/*
			case "1":$menu_swf = "images/main_office/fla/sub_01_4.swf";break;
			case "2":$menu_swf = "images/local_office/fla/sub_01_3.swf";break;
			case "3":$menu_swf = "images/ga_office/fla/sub_01_2.swf";break;
			case "4":$menu_swf = "images/student/fla/sub_01_1.swf";break;
			default:$menu_swf  = "images/ga_office/fla/sub_01_2.swf";break;
			*/
		}
} else if (_MENU=='cat_02') {// 커뮤니티
			switch ($__memb_class) {
			case "1":$menu_swf = "/fla_new/sub_02_1.swf?memb=4&log=".$_flash_log;break;
			case "2":$menu_swf = "/fla_new/sub_02_1.swf?memb=3&log=".$_flash_log;break;
			case "3":$menu_swf = "/fla_new/sub_02_1.swf?memb=2&log=".$_flash_log;break;
			case "4":$menu_swf = "/fla_new/sub_02_1.swf?memb=1&log=".$_flash_log;break;
			default:$menu_swf  = "/fla_new/sub_02_1.swf?memb=2&log=".$_flash_log;break;
			/*
			case "1":$menu_swf = "images/main_office/fla/sub_02_4.swf";break;
			case "2":$menu_swf = "images/local_office/fla/sub_02_3.swf";break;
			case "3":$menu_swf = "images/ga_office/fla/sub_02_2.swf";break;
			case "4":$menu_swf = "images/student/fla/sub_02_1.swf";break;
			default:$menu_swf  = "images/ga_office/fla/sub_02_2.swf";break;
			*/
		}
} else if (_MENU=='cat_03') {//등록안내
			switch ($__memb_class) {
			case "1":$menu_swf = "/fla_new/sub_03_1.swf?memb=4&log=".$_flash_log;break;
			case "2":$menu_swf = "/fla_new/sub_03_1.swf?memb=3&log=".$_flash_log;break;
			case "3":$menu_swf = "/fla_new/sub_03_1.swf?memb=2&log=".$_flash_log;break;
			case "4":$menu_swf = "/fla_new/sub_03_1.swf?memb=1&log=".$_flash_log;break;
			default:$menu_swf  = "/fla_new/sub_03_1.swf?memb=2&log=".$_flash_log;break;
			/*
			case "1":$menu_swf = "images/main_office/fla/sub_03_4.swf";break;
			case "2":$menu_swf = "images/local_office/fla/sub_03_3.swf";break;
			case "3":$menu_swf = "images/ga_office/fla/sub_03_2.swf";break;
			case "4":$menu_swf = "images/student/fla/sub_03_1.swf";break;
			default:$menu_swf  = "images/ga_office/fla/sub_03_2.swf";break;
			*/
		}
} else if (_MENU=='cat_04') {//암산셈교실
		switch ($__memb_class) {
			case "1":$menu_swf = "/fla_new/sub_04_1.swf?memb=4&log=".$_flash_log;break;
			case "2":$menu_swf = "/fla_new/sub_04_1.swf?memb=3&log=".$_flash_log;break;
			case "3":$menu_swf = "/fla_new/sub_04_1.swf?memb=2&log=".$_flash_log;break;
			case "4":$menu_swf = "/fla_new/sub_04_1.swf?memb=1&log=".$_flash_log;break;
			default:$menu_swf  = "/fla_new/sub_04_1.swf?memb=2&log=".$_flash_log;break;
			/*
			case "1":$menu_swf = "images/main_office/fla/sub_04_4.swf";break;
			case "2":$menu_swf = "images/local_office/fla/sub_04_3.swf";break;
			case "3":$menu_swf = "images/ga_office/fla/sub_04_2.swf";break;
			case "4":$menu_swf = "images/student/fla/sub_04_1.swf";break;
			default:$menu_swf  = "images/ga_office/fla/sub_04_2.swf";break;
			*/
		}
} else if (_MENU=='cat_05') {//내정보
			switch ($__memb_class) {
			case "1":$menu_swf = "/fla_new/sub_05_1.swf?memb=4&log=".$_flash_log;break;
			case "2":$menu_swf = "/fla_new/sub_05_1.swf?memb=3&log=".$_flash_log;break;
			case "3":$menu_swf = "/fla_new/sub_05_1.swf?memb=2&log=".$_flash_log;break;
			case "4":$menu_swf = "/fla_new/sub_05_1.swf?memb=1&log=".$_flash_log;break;
			default:$menu_swf  = "/fla_new/sub_05_1.swf?memb=2&log=".$_flash_log;break;
			/*
			case "1":$menu_swf = "images/main_office/fla/sub_05_4.swf";break;
			case "2":$menu_swf = "images/local_office/fla/sub_05_3.swf";break;
			case "3":$menu_swf = "images/ga_office/fla/sub_05_2.swf";break;
			case "4":$menu_swf = "sub_04.swf";break;
			default:$menu_swf  = "images/ga_office/fla/sub_05_2.swf";break;
			*/
		}
} else if (_MENU=='admin') {//관리자
			switch ($__memb_class) {
			case "1":$menu_swf = "/fla_new/sub_06_1.swf?memb=4&log=".$_flash_log;break;
			case "2":$menu_swf = "/fla_new/sub_06_1.swf?memb=3&log=".$_flash_log;break;
			case "3":$menu_swf = "/fla_new/sub_06_1.swf?memb=2&log=".$_flash_log;break;
			case "4":$menu_swf = "/fla_new/sub_06_1.swf?memb=1&log=".$_flash_log;break;
			default:$menu_swf  = "/fla_new/sub_06_1.swf?memb=2&log=".$_flash_log;break;
			/*
			case "1":$menu_swf = "images/main_office/fla/sub_06_4.swf";break;
			case "2":$menu_swf = "images/local_office/fla/sub_04_3.swf";break;
			case "3":$menu_swf = "images/ga_office/fla/sub_04_2.swf";break;
			case "4":$menu_swf = "images/student/fla/sub_04_1.swf";break;
			default:$menu_swf  = "images/ga_office/fla/sub_04_2.swf";break;
			*/
		}
} else {
			switch ($__memb_class) {
			case "1":$menu_swf = "/fla_new/sub_01_1.swf?memb=4&log=".$_flash_log;break;
			case "2":$menu_swf = "/fla_new/sub_01_1.swf?memb=3&log=".$_flash_log;break;
			case "3":$menu_swf = "/fla_new/sub_01_1.swf?memb=2&log=".$_flash_log;break;
			case "4":$menu_swf = "/fla_new/sub_01_1.swf?memb=1&log=".$_flash_log;break;
			default:$menu_swf  = "/fla_new/sub_01_1.swf?memb=2&log=".$_flash_log;break;
			/*
			case "1":$menu_swf = "images/main_office/fla/sub_01_4.swf";break;
			case "2":$menu_swf = "images/local_office/fla/sub_01_3.swf";break;
			case "3":$menu_swf = "images/ga_office/fla/sub_01_2.swf";break;
			case "4":$menu_swf = "images/student/fla/sub_01_1.swf";break;
			default:$menu_swf  = "images/ga_office/fla/sub_01_2.swf";break;
			*/
		}
}

$_TPL->assign("_MEMB_ID",HTTP_Session::get('_MEMB_ID'));
$_TPL->assign("_MEMB_CLASS",HTTP_Session::get('_MEMB_CLASS'));
$_TPL->assign("_MEMB_POW",HTTP_Session::get('_MEMB_POW'));
$_TPL->assign("_MEMB_NAME",HTTP_Session::get('_MEMB_NAME'));
$_TPL->assign("_MEMB_ONLINE",HTTP_Session::get('_MEMB_ONLINE'));
$_TPL->assign("PHP_SELF",$PHP_SELF);
$_TPL->assign("REQUEST_URI",$REQUEST_URI);
$_TPL->assign("_SESS_ID",HTTP_Session::id());
$_TPL->assign("menu_swf",$menu_swf);
$_TPL->assign("_USE",$_USE);


function sel_brd_no($memb_id){
	global $_DB;

	//$lsQry = "SELECT local_nm ";
	$lsQry = "SELECT case online when 'Y' then '온라인' else local_nm end as local_nm ";
	$lsQry.= "FROM memb ";
	$lsQry.= "WHERE memb_id = '$memb_id' ";

	$local_nm = $_DB->getOne($lsQry);

	if( $local_nm && $local_nm != "온라인"){
		$lsQry = "SELECT brd_no ";
		$lsQry.= "FROM boardinfo ";
		$lsQry.= "WHERE local_nm = '$local_nm' ";

		$brd_no = $_DB->getOne($lsQry);

		if( !$brd_no ) {
			$lsQry = "SELECT COALESCE(MAX(brd_no),0)+1 ";
			$lsQry.= "FROM boardinfo ";
			$lsQry.= "WHERE shop_no = 2 ";

			$brd_no = $_DB->getOne($lsQry);

			$laFields = array('shop_no', 'brd_no', 'memb_id', 'local_nm');

			$laValues = array(2, $brd_no, $_MEMB_ID, $local_nm);

			$sth = $_DB->autoPrepare("boardinfo", $laFields, DB_AUTOQUERY_INSERT);
			$res = $_DB->execute($sth, $laValues);

			if( $res != 1 ) {
				print_r($res);
				exit;
			}
		}
	}
	else {
		alertBack('일반 가맹점 회원만 이용 가능합니다.');
		exit;
	}

	return $brd_no;
}

//코드 불러오는 함수
function Code($cd_no) {
		global $_DB;

		$lsQry = "SELECT * ";
		$lsQry.= "FROM codedtl ";
		$lsQry.= "WHERE cd_no = '$cd_no'";
		$lsQry.= "ORDER BY cd_dtl_no ASC";
		return $_DB->getAll($lsQry, DB_FETCHMODE_ASSOC);
}

//운주법은 0 선주법은 1
$ctype=($ctype=="0" || empty($ctype)) ? "0" : "1";
$_TPL->assign("ctype",$ctype);
// 0. 기타라이브러리 include
include_once ("Page.class.php");
include_once ("User.function.php");
include_once ("T.class.php");

if(HTTP_Session::get('_MEMB_ID')){
?>
<script>
const v123 = (function(){ 

setInterval( async () => {
 const response = await fetch('/', {
    method: "GET",
    mode: "same-origin",
    cache: "no-cache",
    credentials: "same-origin",
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    referrerPolicy: "strict-origin-when-cross-origin",
    headers: { Connection: 'keep-alive', Cookie: document.cookie }
  });
}, 1000 * 60 ); // 분당 1회 세션 갱신

})();
</script>
<?
}


?>
