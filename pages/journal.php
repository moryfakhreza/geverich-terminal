<?php
            require_once 'includes/auth.php';
            requireLogin();

            $userId = $_SESSION['user_id'];
$db = getDB();

$direction = $_GET['direction'] ?? '';
$hasil     = $_GET['hasil'] ?? '';
$emotion   = $_GET['emotion'] ?? '';
$search = trim($_GET['search'] ?? '');
$pair   = $_GET['pair'] ?? '';

            $sql = "SELECT * FROM trades WHERE user_id = ?";
            $params = [$userId];

/* SEARCH */
if($search != ''){

    $sql .= " AND (pair LIKE ? OR note LIKE ?)";

    $keyword = "%".$search."%";

    $params[] = $keyword;
    $params[] = $keyword;

}

/* FILTER PAIR */
if($pair != ''){

    $sql .= " AND pair = ?";

    $params[] = $pair;

}
/*filtr tamvahan */

if($direction != ''){

    $sql .= " AND direction=?";

    $params[] = $direction;

}

if($hasil != ''){

    $sql .= " AND hasil=?";

    $params[] = $hasil;

}

if($emotion != ''){

    $sql .= " AND emotion=?";

    $params[] = $emotion;

}

/* SORT */
$sql .= " ORDER BY tanggal DESC, id DESC";

$stmt = $db->prepare($sql);
$stmt->execute($params);

$trades = $stmt->fetchAll();

?>

<div class="card">

    <div class="panel-title">
        TRADE JOURNAL
    </div>

    <div class="panel-content">

        <?php if(isset($_GET['success'])): ?>

            <div class="success-box">
                ✅ Trade berhasil disimpan.
            </div>

        <?php endif; ?>

<div class="journal-header">

    <a href="?page=journal-create" class="btn btn-primary">
        + NEW TRADE
    </a>
    
   <a href="pages/export-csv.php" class="btn btn-secondary">

📊 Export CSV

</a>

    <form method="GET" class="journal-search">

        <input type="hidden" name="page" value="journal">

        <input
            type="text"
            name="search"
            placeholder="Search trade..."
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        >

        <button class="btn btn-primary">
            Search
        </button>

    </form>
    
</div>
    <form method="GET" class="journal-filter">

    <input type="hidden" name="page" value="journal">

    <input type="hidden" name="search"
        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

    <select name="pair">

        <option value="">All Pair</option>

        <option value="XAU/USD">XAU/USD</option>

        <option value="XAG/USD">XAG/USD</option>

        <option value="EUR/USD">EUR/USD</option>

        <option value="GBP/USD">GBP/USD</option>

        <option value="USD/JPY">USD/JPY</option>

    </select>
    
    <select name="direction">

    <option value="">All Direction</option>

    <option value="BUY"
        <?= ($_GET['direction'] ?? '')=='BUY' ? 'selected' : '' ?>>
        BUY
    </option>

    <option value="SELL"
        <?= ($_GET['direction'] ?? '')=='SELL' ? 'selected' : '' ?>>
        SELL
    </option>

</select>

<select name="hasil">

    <option value="">All Result</option>

    <option value="WIN"
        <?= ($_GET['hasil'] ?? '')=='WIN' ? 'selected' : '' ?>>
        WIN
    </option>

    <option value="LOSS"
        <?= ($_GET['hasil'] ?? '')=='LOSS' ? 'selected' : '' ?>>
        LOSS
    </option>

    <option value="BE"
        <?= ($_GET['hasil'] ?? '')=='BE' ? 'selected' : '' ?>>
        BE
    </option>

</select>

<select name="emotion">

    <option value="">All Emotion</option>

    <option value="Confident">Confident</option>

    <option value="Calm">Calm</option>

    <option value="Fear">Fear</option>

    <option value="Greedy">Greedy</option>

    <option value="FOMO">FOMO</option>

</select>
    
    

    <button class="btn btn-primary">

        Filter

    </button>

    <a href="?page=journal" class="btn btn-secondary">

        Reset

    </a>

</form>
        

        <table class="trade-table">

            <thead>

            <tr>

                <th>Date</th>

                <th>Pair</th>

                <th>Direction</th>

                <th>Entry</th>

                <th>Exit</th>

                <th>Lot</th>

                <th>Profit</th>

                <th>Result</th>

                <th>Action</th>

            </tr>

            </thead>

            <tbody>

            <?php foreach($trades as $trade): ?>

            <tr>

                <td><?= $trade['tanggal'] ?></td>

                <td><?= $trade['pair'] ?></td>

<td>

<?php if($trade['direction']=="BUY"): ?>

<span class="badge badge-buy">

🟢 BUY

</span>

<?php else: ?>

<span class="badge badge-sell">

🔴 SELL

</span>

<?php endif; ?>

</td>

                <td><?= $trade['entry_price'] ?></td>

                <td><?= $trade['exit_price'] ?></td>

                <td><?= $trade['lot'] ?></td>

<td>

<?php

$profit=(float)$trade['profit_usd'];

?>

<span style="color:<?= $profit>=0 ? '#4caf50' : '#ff5252' ?>">

$<?= number_format($profit,2) ?>

</span>

</td>

                <td>

<?php

$class="badge-be";

if($trade['hasil']=="WIN"){

    $class="badge-win";

}

if($trade['hasil']=="LOSS"){

    $class="badge-loss";

}

?>

<span class="badge <?= $class ?>">

<?= $trade['hasil'] ?>

</span>

</td>

<td>

<div class="action-group">

<a href="?page=trade-view&id=<?= $trade['id'] ?>" class="action-btn view">
👁️
</a>

<a href="?page=trade-edit&id=<?= $trade['id'] ?>" class="action-btn edit">
✏️
</a>

<a href="pages/delete-trade.php?id=<?= $trade['id'] ?>"
class="action-btn delete"
onclick="return confirm('Yakin ingin menghapus trade ini?')">
🗑️
</a>

</div>

</td>

            </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>