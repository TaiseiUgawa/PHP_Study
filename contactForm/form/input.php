<!-- PHP メイン処理部分　画面繊維　(開始)　　 -->
<?php 
    require 'validation.php';
    session_start();
    header('X-FRAME-OPTIONS:DENY');

    //POST通信デバック確認 
    // if(!empty($_POST)){
    //     echo('<pre>');
    //     var_dump($_POST);
    //     echo('</pre>');
    // }

    // スクリプト対策
    function h($str){
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }


    // 画面繊維処理
    $pageFlag = 0;
    $errors = validation($_POST);

    if(!empty($_POST['btn_confirm']) && empty($errors)){
        $pageFlag = 1;
    }

    if(!empty($_POST['btn_submit'])){
        $pageFlag = 2;
    }

?>
<!-- PHP メイン処理部分 (終了)　　　 -->


<!--                         HTML           (開始)                -->
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
<body>



<!--                                          入力画面                                           -->
<?php if($pageFlag === 0) : ?>
    <?php
    if(!isset($_SESSION['csrfToken'])){
        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrfToken'] = $csrfToken;
    }
    $token = $_SESSION['csrfToken'];
    ?>

<!--                                        エラーメッセージ表示                                   -->
<?php if(!empty($errors) && !empty($_POST['btn_confirm'])) :?>
    <?php  echo ('<ul>'); ?>
        <?php 
            foreach($errors as $error){
                echo '<li>' . $error . '</li>';
            }
        ?>
    <?php  echo ('</ul>'); ?>
<?php endif ;?>


<!--                                        フォーム画面部分（開始）　                               -->
<div class="container">
    <div class="row">
        <div class= "col-md-6">
            <form method="POST" action="input.php">
            <!-- 氏名 -->
            <div class ="form-group">
                <label for="your_name">氏名</label> 
                <input type="text" class="form-control" id="your_name" name="your_name" value="<?php if(!empty($_POST['your_name'])){ echo(h($_POST['your_name'])); }?>" required>
            </div>


            <!-- メールアドレス -->
            <div class ="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php if(!empty($_POST['email'])){ echo(h($_POST['email'])); }?>" required>        
            </div>

            <!-- ホームページ -->
            <div class ="form-group">
                <label for="url">ホームページ</label>
                <input type="url" class="form-control" id="url" name="url" value="<?php if(!empty($_POST['url'])){ echo(h($_POST['url'])); }?>">        
            </div>

            <!-- 性別 -->
            <div class="from-check form-check-inline" >
                性別
                <!-- 男性 -->
                <input type="radio" class="form-check-input" name="gender" value="0" id="gender0"
                <?php if(isset($_POST['gender']) && $_POST['gender'] === '0'){ echo 'checked';} ?>>
                <label class="form-check-label" for="gender0">男性</label>

                <!-- 女性 -->
                <input type="radio" class="form-check-input"　name="gender" value="1" id="gender1" 
                <?php if(isset($_POST['gender']) && $_POST['gender'] === '1'){ echo 'checked';} ?>>
                <label class="form-check-label" for="gender1">女性</label>
            </div>

            <!-- 年齢 -->

            <div class="form-group">
                <label for="age">年齢</label>
                    <select class="form-control" id="age" name="age">
                        <option value="">選択してください</option>
                        <option value="1" <?php if(isset($_POST['age']) && $_POST['age'] === '1')
                        { echo 'selected';} ?>>~19歳</option>
                        <option value="2" <?php if(isset($_POST['age']) && $_POST['age'] === '2')
                        { echo 'selected';} ?>>20歳~29歳</option>
                        <option value="3" <?php if(isset($_POST['age']) && $_POST['age'] === '3')
                        { echo 'selected';} ?>>30歳~39歳</option>
                        <option value="4" <?php if(isset($_POST['age']) && $_POST['age'] === '4')
                        { echo 'selected';} ?>>40歳~49歳</option>
                        <option value="5" <?php if(isset($_POST['age']) && $_POST['age'] === '5')
                        { echo 'selected';} ?>>50歳~59歳</option>
                        <option value="6" <?php if(isset($_POST['age']) && $_POST['age'] === '6')
                        { echo 'selected';} ?>>60歳~</option>
                    </select>
            </div>

            <!-- お問合せ内容 -->

            <div class="form-group">
                <label for="contact">お問合せ内容</label>
                <textarea class="form-control" id="contact" rows="3" name="contact">
                <?php if(!empty($_POST['contact'])){ echo(h($_POST['contact'])); }?>
                </textarea>
            </div>

            <!-- 注意事項 -->

            <div class="form-check">
            <input class="form-check-input" type="checkbox" id="caution" name="caution" value="1">
            <label class="form-check-label" for="caution">注意事項にチェック</label>
            <br>
            </div>
            

            <!-- 確認ボタン -->
            <input class="btn btn-info" type="submit" name="btn_confirm" value="確認する">
            <input type="hidden" name="csrf" value="<?php echo $token; ?>">
            </form>

        </div><!-- col-md-6 -->
    </div><!-- row -->
</div><!-- container -->

<!--                               フォーム画面部分（終了）      　                         -->

<?php endif; ?>



<!--                                     確認画面                                          -->
<?php if($pageFlag === 1) : ?>

    <?php if($_POST['csrf'] === $_SESSION['csrfToken']) : ?>

        <!-- 氏名 -->
        <form method="POST" action="input.php">
        氏名
        <?php echo h($_POST['your_name']); ?>
        <br>

        <!-- メールアドレス -->
        メールアドレス
        <?php echo h($_POST['email']); ?>
        <br>

        <!-- ホームページ -->
        ホームページ
        <?php echo h($_POST['url']); ?>
        <br>

        <!-- 性別 -->
        性別
        <?php if($_POST['gender'] === '0'){ echo '男性';} ?>
        <?php if($_POST['gender'] === '1'){ echo '女性';} ?>
        <br>

        <!-- 年齢 -->
        年齢
        <?php 
            if($_POST['age'] === '1'){ echo('~19歳');}
            if($_POST['age'] === '2'){ echo('20歳~29歳');}
            if($_POST['age'] === '3'){ echo('30歳~39歳');}
            if($_POST['age'] === '4'){ echo('40歳~49歳');}
            if($_POST['age'] === '5'){ echo('50歳~59歳');}
            if($_POST['age'] === '6'){ echo('60歳~');}
        ?>
        <br>

        <!-- お問い合わせ内容 -->
        お問い合わせ内容
        <?php echo h($_POST['contact']); ?>
        <br>

        <!-- 確認画面ボタン類 -->
        <input type="submit" name="back" value="戻る">
        <input type="submit" name="btn_submit" value="送信する">

        <!-- 入力内容保持　画面遷移時 -->
        <input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']); ?>">
        <input type="hidden" name="email" value="<?php echo h($_POST['email']); ?>">
        <input type="hidden" name="url" value="<?php echo h($_POST['url']); ?>">
        <input type="hidden" name="gender" value="<?php echo h($_POST['gender']); ?>">
        <input type="hidden" name="age" value="<?php echo h($_POST['age']); ?>">
        <input type="hidden" name="contact" value="<?php echo h($_POST['contact']); ?>">
        <input type="hidden" name="csrf" value="<?php echo h($_POST['csrf']); ?>">
        </form>

    <?php endif; ?>

<?php endif; ?>



<!--                                        完了画面                           -->
<?php if($pageFlag === 2) : ?>

<?php if($_POST['csrf'] === $_SESSION['csrfToken']) : ?>

<?php  
    require '../mainte/insert.php';
    insertContact($_POST);
?>

送信が完了しました。

<?php unset($_SESSION['csrfToken']); ?>
<?php endif; ?>

<?php endif; ?>

    
<!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
   
  </body>
</html>
<!--                         HTML    (終了)                       -->