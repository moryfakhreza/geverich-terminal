<?php require 'components/dashboard-stats.php'; ?>

<?php require 'components/chart.php'; ?>
<?php require 'components/risk-engine.php'; ?>
<?php require_once 'includes/equity.php';

$user_id = $_SESSION['user_id'];

$equity = getUserEquity($db, $user_id);
?>
