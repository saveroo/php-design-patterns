<?php

ini_set('display_errors', 1);

include('middleware/declaration.php');

use Controller\Authentication;
use Controller\User;
use Controller\Helpers\Debug;
use Controller\Auth;
use Controller\Helpers\Front;

use Controller\FileController;
use Controller\ProductController;
use Controller\Product;
use Controller\DbProto;


/*
 * Switching between page to make granting access easier
 * perhaps it is called Front-Controller Pattern, but still spagheti
 */
switch($_GET['views'])
{

	case 'login':
			Auth::grant('');
			include __DIR__."/views/login.php";
		break;
	case 'register':
		include __DIR__."/views/register.php";
	break;
	case 'home':
			include __DIR__ . "/views/home.php";
		break;
	case 'product':
			include __DIR__ . "/views/product.php";
		break;
	case 'dashboard':
		Auth::grant('Admin');
		include __DIR__ . "/views/dashboard.php";
		break;
	case 'edit':
		include __DIR__."/views/edit.php";
		break;
	case 'cart':
		Auth::grant(['Admin', 'Member']);
		include __DIR__."/views/cart.php";
		break;
	default:
		if(!isset($_GET['views'])){
			header("Location: index.php?views=home");
		}
	break;
}


/*
 * Separating between view and controller for Single responsibility.
 */
if(isset($_REQUEST['Controller']))
{
	switch ($_GET['Controller'])
	{
		case 'auth': //Auth Controller
			if(isset($_GET['Controller']) && $_GET['Controller'] === "auth"){
				if(isset($_POST['username'], $_POST['password']))
					ob_start();
					$auth = Auth::user($_POST);
				    //$auth = new Authentication($_POST['username'], $_POST['password']);

				if(Auth::role() == 'Member' || Auth::role() == 'Admin') {
					header("Location: index.php?views=home");
//					Front::redirect('index.php?views=home');
					ob_end_flush();
				}
			}
			break;
		case 'register': //Register Facade
				//			$validation = new \Controller\Validation($_POST);
				//			$validation->displayAlert($_POST);
				$register = User::CreateUser($_POST);
				//$register->displayAlert($_POST);
			break;
		case 'logout':
				Auth::destroy();
				Front::redirect('index.php');
			break;
		case 'addproduct':
			Product::add($_POST, $_FILES);
			ob_end_flush();
			break;
		case 'delete_product':
			if(isset($_REQUEST['product_id']))
			{
				$db = DbProto::getInstance();
				$id =htmlentities($_REQUEST['product_id']);
				$make = $db->make()->query("DELETE FROM product WHERE cake_id=$id");
				Front::redirect('index.php?views=product');
				//header('index.php?views=product&Controller=delete_product');
			}
			break;
		case 'delete_user':
			if(isset($_REQUEST['user_id']))
			{
				$db = DbProto::getInstance();
				$id =htmlentities($_REQUEST['user_id']);
				$make = $db->make()->query("DELETE FROM users WHERE user_id=$id");
				Front::pushMessage('USER', "User with id $id Deleted by ".Auth::getUsername());
				Front::redirect('index.php?views=dashboard');
				//header('index.php?views=product&Controller=delete_product');
			}
			break;
		case 'edit_product':
			//INI BARBAR KARNA WAKTU MEPET
			if(isset($_POST['product_id'])) {
				//Product::add($_POST, $_FILES);
				$name = $_POST['ckName'];
				$stock =$_POST['ckStock'];
				$price =$_POST['ckPrice'];
				$id = $_POST['product_id'];
				if($_FILES['ckImage']['name'] === ''){
					$image = DbProto::getInstance()->make()->query("SELECT * FROM product where cake_id='".$id."'")->fetch_object();
					$query= "UPDATE product SET ckStock='$stock', ckName='$name', ckPrice='$price', ckImage='$image->ckImage' WHERE cake_id=$id";

				}else{
					$files = new FileController($_FILES, "assets/");
					$image = $files->getLocation();
					$query= "UPDATE product SET ckStock='$stock', ckName='$name', ckPrice='$price', ckImage='$image' WHERE cake_id=$id";

				}
				$db = new DbProto();
				$db->mysqli->query($query);
				Front::pushMessage('Product', "Product $name edited");
				Front::redirect('index.php?views=product');
				}
			break;
		case 'search':

			break;
		case 'addtocart':
//			Debug::showDump($_SESSION);
			if(isset($_REQUEST['cake_id']))
			{
				$id = $_REQUEST['cake_id'];
				$result = DbProto::getInstance()->make()->query("SELECT * FROM product WHERE cake_id=$id")->fetch_array();
				extract($result);
				$_SESSION['login']['cart'][$id]['qty'] += 1;
				Front::pushMessage('Cart', "$ckName was added to your Cart!");
				Front::redirect('index.php?views=product');
			}
			break;
		case 'remove_cart':
			if(isset($_REQUEST['item_id']))
			{
				$id = $_REQUEST['item_id'];
				$result = DbProto::getInstance()->make()->query("SELECT * FROM product WHERE cake_id=$id")->fetch_array();
				extract($result);
				unset($_SESSION['login']['cart'][$id]);
				Front::pushMessage('Cart', "$ckName was removed from your cart!");
				//Front::redirect('index.php?views=cart');
			}
			break;
		case 'update_cart':
			if(isset($_REQUEST['qty']))
			{
				$id = $_REQUEST['item_id'];
				$result = DbProto::getInstance()->make()->query("SELECT * FROM product WHERE cake_id=$id")->fetch_array();
				extract($result);
				$_SESSION['login']['cart'][$id]['qty'] = $_REQUEST['qty'];
				Front::pushMessage('Cart', "$ckName quantity updated from your cart!");
				Front::redirect('index.php?views=cart');
			}
			break;
		default:
			break;

	}
}

?>
