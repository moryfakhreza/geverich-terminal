<?php

require_once __DIR__ . '/../db.php';


class TradeRepository
{
  private PDO $db;

  public function __construct() {
    $this->db = getDB();
  }

  /**
  * Menyimpan trade baru
  */
    public function create(array $data): bool
    {
        $sql = "
        INSERT INTO trades
        (
            user_id,
            tanggal,
            pair,
            direction,
            entry_price,
            sl,
            tp,
            exit_price,
            lot,
            profit_usd,
            hasil,
            emotion,
            strategy,
            rr,
            note
        )
        VALUES
        (
            :user_id,
            :tanggal,
            :pair,
            :direction,
            :entry_price,
            :sl,
            :tp,
            :exit_price,
            :lot,
            :profit_usd,
            :hasil,
            :emotion,
            :strategy,
            :rr,
            :note
        )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function update(array $data): bool
    {
        $sql = "
    UPDATE trades SET

        tanggal = :tanggal,
        pair = :pair,
        direction = :direction,
        entry_price = :entry_price,
        sl = :sl,
        tp = :tp,
        exit_price = :exit_price,
        lot = :lot,
        profit_usd = :profit_usd,
        hasil = :hasil,
        emotion = :emotion,
        strategy = :strategy,
        rr = :rr,
        note = :note

    WHERE id = :id
    AND user_id = :user_id
    ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }
  
  /**
 * Ambil trade terbaru
 */
public function latestTrades(int $userId, int $limit = 10): array
{
    $sql = "
        SELECT
            tanggal,
            pair,
            direction,
            hasil,
            profit_usd,
            rr,
            strategy,
            emotion,
            note
        FROM trades
        WHERE user_id = :user_id
        ORDER BY tanggal DESC, id DESC
        LIMIT :limit
    ";

    $stmt = $this->db->prepare($sql);

    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}