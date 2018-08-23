<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Application;

$context = Application::getInstance()->getContext();
$request = $context->getRequest();

$tmp_dir = '/upload/tmp/custom/';

if ($request->getPost('action')  == 'FILE') {
    
    if ($request->getFile("files")) {
        foreach ($request->getFile("files") as $key => $arValues) {
            foreach ($arValues as $k => $value) {
                $arFiles[$k][$key] = $value;
            }
        }

        if (!is_dir(Application::getDocumentRoot() . $tmp_dir)) {
            mkdir(Application::getDocumentRoot() . $tmp_dir, 0755, true);
        }

        if (!empty($arFiles)) {
            foreach ($arFiles as &$file) {
                $file['new_name'] = time() . '-' . $file['name'];

            }
            unset($file);

            foreach ($arFiles as $arFile) {
                if (move_uploaded_file($arFile['tmp_name'], Application::getDocumentRoot() . $tmp_dir . $arFile['new_name'])) {
                    $_SESSION['TMP_FILES'][$_SESSION['fixed_session_id']][] = $tmp_dir . $arFile['new_name'];
                }
            }
        }
    } elseif (strlen($request['del']) > 0) {
        foreach ($_SESSION['TMP_FILES'][$_SESSION['fixed_session_id']] as $k => $value) {
            if (strpos($value, $request['del'])) {
                unlink(Application::getDocumentRoot() . $value);
                unset($_SESSION['TMP_FILES'][$_SESSION['fixed_session_id']][$k]);
            }
        }
        $_SESSION['TMP_FILES'][$_SESSION['fixed_session_id']] = array_values($_SESSION['TMP_FILES'][$_SESSION['fixed_session_id']]);
    }
    
}

?>