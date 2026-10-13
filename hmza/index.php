<?php
include './inc/db.php';
include './inc/form.php';
include './inc/select.php';
mysqli_close($conn);
$winner = null;
if (!empty($users)) {
    $winner = $users[array_rand($users)];
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رياضات الالكترونية - التسجيل</title>
    <link href="./images/pngtree-soccer-championship-emblems-png-image_20100298.png">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css"
        rel="stylesheet"
        integrity="sha384-CfCrinSRH2IR6a4e6fy2q6ioOX7O6Mtm1L9vRvFZ1trBncWmMePhzvafv7oIcWiW"
        crossorigin="anonymous"
    >
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .loader-con {
            display: none;
            text-align: center;
            margin: 30px auto;
        }
        #loader {
            display: inline-block;
        }
        #circularLoader {
            max-width: 100%;
            height: auto;
        }
        /* نتيجة الفائز */
        #winnerResult {
            margin-top: 30px;
            min-height: 150px;
        }
        .winner-box {
            padding: 30px;
            border-radius: 20px;
            background: #f8f9fa;
            border: 2px solid #4285f4;
            animation: winnerAppear 0.8s ease;
        }
        .winner-box h2,
        .winner-box h1 {
            margin-bottom: 15px;
        }
        @keyframes winnerAppear {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        #confettiCanvas {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-4 fw-normal">
                رياضات الالكترونية
            </h1>
            <p class="lead fw-normal">
                <img src="pngtree-soccer-championship-emblems-png-image_20100298.png" width="100">
                <br>
                المرشحين في البطولة
            </p>
            <h3 id="demo"></h3>
            <a class="btn btn-outline-secondary" href="#">
                
                Coming soon
            </a>
        </div>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            نوفر لكم تشكيلة متنوعة من الألعاب تناسب جميع الأذواق
        </li>
        <li class="list-group-item">
            ألعاب الجمعات والأهل والأصدقاء، إلى ألعاب القيمنق والمغامرات والتحديات
        </li>
        <li class="list-group-item">
            هدفنا أن نوفر لكم ألعابًا تضيف المتعة والحماس لكل جلسة وتجعل كل لحظة تستحق اللعب. 🤍
        </li>
        <li class="list-group-item">
            اختيارات متنوعة لكل جلسة، وكل مجموعة، وكل شخص يحب يعيش تجربة لعب مختلفة.
        </li>
        <li class="list-group-item">
            اجمعوا، العبوا، واستمتعوا بوقتكم مع ألعاب تناسب كل جلسة وكل مزاج
        </li>
    </ul>
    <div class="position-relative text-center">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <form
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                method="POST"
            >
                <h3 class="mb-4">
                    الرجاء تسجيل معلوماتك
                </h3>
                
                <div class="mt-4">
                    <label for="firstName" class="form-label">
                        الاسم الأول
                    </label>
                    <input
                        type="text"
                        name="firstName"
                        class="form-control"
                        id="firstName"
                        value="<?php echo htmlspecialchars($_POST['firstName'] ?? ''); ?>"
                    >
                    <div class="form-text error">
                        <?php echo $errors['firstNameError'] ?? ''; ?>
                    </div>
                </div>
              
                <div class="mt-4">
                    <label for="lastName" class="form-label">
                        الاسم الثاني
                    </label>
                    <input
                        type="text"
                        name="lastName"
                        class="form-control"
                        id="lastName"
                        value="<?php echo htmlspecialchars($_POST['lastName'] ?? ''); ?>"
                    >
                    <div class="form-text error">
                        <?php echo $errors['lastNameError'] ?? ''; ?>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="email" class="form-label">
                        البريد الإلكتروني
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        id="email"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                    >
                    <div class="form-text error">
                        <?php echo $errors['emailError'] ?? ''; ?>
                    </div>
                </div>
               
                <div class="mb-3 mt-4 form-check">
                    <input
                        type="checkbox"
                        name="terms"
                        value="1"
                        class="form-check-input"
                        id="exampleCheck1"
                    >
                    <label
                        class="form-check-label"
                        for="exampleCheck1"
                    >
                        هل أنت موافق على شروط البطولة؟
                    </label>
                </div>
                
                <button
                    type="submit"
                    name="submit"
                    class="btn btn-primary"
                >
                    تسجيل
                </button>
            </form>
        </div>
    </div>
    <br>
    <div class="loader-con" id="loaderContainer">
        <div id="loader">
            <canvas
                id="circularLoader"
                width="200"
                height="200"
            ></canvas>
        </div>
    </div>
    <div class="col-12 text-center mb-3">
        <button
            id="winner"
            type="button"
            class="btn btn-primary"
        >
            اختيار المرشح
        </button>
    </div>
    <div
        id="winnerResult"
        class="text-center mb-5"
    ></div>
  
    <div id="cards" class="row mb-5 pb-5">
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <div class="col-sm-6">
                    <div class="card my-2 bg-light">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                echo htmlspecialchars(
                                    $user['firstName'] . ' ' . $user['lastName'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>
                            </h5>
                            <p class="card-text">
                                <?php
                                echo htmlspecialchars(
                                    $user['email'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">
                    لا يوجد مسجلين حتى الآن
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>
<canvas id="confettiCanvas"></canvas>
<script src="./java s/script.js"></script>
<script>
var canvas = document.getElementById('circularLoader');
var ctx = canvas.getContext('2d');
var loaderContainer = document.getElementById('loaderContainer');
var winnerButton = document.getElementById('winner');
var winnerResult = document.getElementById('winnerResult');
var al = 0;
var start = -Math.PI / 2;
var cw = canvas.width;
var ch = canvas.height;
var sim = null;
winnerButton.addEventListener('click', function () {
    winnerButton.disabled = true;
    loaderContainer.style.display = 'block';
    winnerResult.innerHTML = '';
    al = 0;
    ctx.clearRect(0, 0, cw, ch);
    sim = setInterval(progressSim, 50);
});
function progressSim() {
    var diff = (al / 100) * Math.PI * 2;
    ctx.clearRect(0, 0, cw, ch);
    ctx.lineWidth = 17;
    ctx.fillStyle = '#4285f4';
    ctx.strokeStyle = '#4285f4';
    ctx.textAlign = 'center';
    ctx.font = '28px monospace';
    ctx.fillText(
        al + '%',
        cw / 2,
        ch / 2 + 10
    );
    ctx.beginPath();
    ctx.arc(
        cw / 2,
        ch / 2,
        75,
        start,
        diff + start,
        false
    );
    ctx.stroke();
    if (al >= 100) {
        clearInterval(sim);
        loaderContainer.style.display = 'none';
        showWinner();
        return;
    }
    al++;
}
function showWinner() {
    winnerResult.innerHTML = `
        <div class="winner-box">
            <h2>🎉 مبروك 🎉</h2>
            <h1>المرشح للبطولة</h1>
            <h2 id="winnerName">
                <?php
                if ($winner) {
                    echo htmlspecialchars(
                        $winner['firstName'] . ' ' . $winner['lastName'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                } else {
                    echo 'لا يوجد مسجلين';
                }
                ?>
            </h2>
        </div>
    `;
    confettiEffect();
}
function confettiEffect() {
    var confettiCanvas = document.getElementById('confettiCanvas');
    var confettiCtx = confettiCanvas.getContext('2d');
    confettiCanvas.width = window.innerWidth;
    confettiCanvas.height = window.innerHeight;
    var pieces = [];
    var colors = [
        '#ff4d6d',
        '#ffd166',
        '#06d6a0',
        '#118ab2',
        '#8338ec'
    ];
    for (var i = 0; i < 150; i++) {
        pieces.push({
            x: Math.random() * confettiCanvas.width,
            y: -20 - Math.random() * confettiCanvas.height,
            w: 8 + Math.random() * 8,
            h: 8 + Math.random() * 8,
            color: colors[
                Math.floor(Math.random() * colors.length)
            ],
            speed: 2 + Math.random() * 4,
            rotation: Math.random() * Math.PI * 2,
            rotationSpeed: (Math.random() - 0.5) * 0.2
        });
    }
    var startTime = Date.now();
    var duration = 5000;
    function animateConfetti() {
        var elapsed = Date.now() - startTime;
        confettiCtx.clearRect(
            0,
            0,
            confettiCanvas.width,
            confettiCanvas.height
        );
        for (var i = 0; i < pieces.length; i++) {
            var p = pieces[i];
            p.y += p.speed;
            p.rotation += p.rotationSpeed;
            confettiCtx.save();
            confettiCtx.translate(p.x, p.y);
            confettiCtx.rotate(p.rotation);
            confettiCtx.fillStyle = p.color;
            confettiCtx.fillRect(
                -p.w / 2,
                -p.h / 2,
                p.w,
                p.h
            );
            confettiCtx.restore();
        }
        if (elapsed < duration) {
            requestAnimationFrame(animateConfetti);
        } else {
            confettiCtx.clearRect(
                0,
                0,
                confettiCanvas.width,
                confettiCanvas.height
            );
        }
    }
    animateConfetti();
}
</script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwxH9JrCjz..."
    crossorigin="anonymous"
></script>
</body>
