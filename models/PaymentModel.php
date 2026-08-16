<?php

class PaymentModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tb_payments';
    }

    public function insertPayment($order_id, $payment_method, $amount, $status)
    {
        $sql = "INSERT INTO {$this->table} (order_id, payment_method, amount, status, payment_date) 
                VALUES (:order_id, :payment_method, :amount, :status, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'order_id' => $order_id,
            'payment_method' => $payment_method,
            'amount' => $amount,
            'status' => $status
        ]);
        return $this->pdo->lastInsertId();
    }
}
