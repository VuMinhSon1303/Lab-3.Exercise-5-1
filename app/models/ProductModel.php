<?php

class ProductModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $query = 'SELECT p.productID, p.productCode, p.productName, p.listPrice, c.categoryName
                  FROM products p
                  INNER JOIN categories c ON p.categoryID = c.categoryID
                  ORDER BY p.productName';

        $statement = $this->db->query($query);
        return $statement->fetchAll();
    }

    public function getAllByCategory(int $categoryId): array
    {
        $statement = $this->db->prepare(
            'SELECT productID, productCode, productName, listPrice
             FROM products
             WHERE categoryID = :category_id
             ORDER BY productName'
        );
        $statement->execute(['category_id' => $categoryId]);
        return $statement->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $statement = $this->db->prepare(
            'SELECT productID, categoryID, productCode, productName, listPrice
             FROM products
             WHERE productID = :id'
        );
        $statement->execute(['id' => $id]);
        $product = $statement->fetch();
        return $product ?: null;
    }

    public function add(string $productCode, string $productName, float $listPrice, int $categoryId): void
    {
        $statement = $this->db->prepare(
            'INSERT INTO products (categoryID, productCode, productName, listPrice)
             VALUES (:category_id, :product_code, :product_name, :list_price)'
        );
        $statement->execute([
            'category_id' => $categoryId,
            'product_code' => $productCode,
            'product_name' => $productName,
            'list_price' => $listPrice,
        ]);
    }

    public function update(int $id, int $categoryId, string $productCode, string $productName, float $listPrice): void
    {
        $statement = $this->db->prepare(
            'UPDATE products
             SET categoryID = :category_id,
                 productCode = :product_code,
                 productName = :product_name,
                 listPrice = :list_price
             WHERE productID = :id'
        );
        $statement->execute([
            'category_id' => $categoryId,
            'product_code' => $productCode,
            'product_name' => $productName,
            'list_price' => $listPrice,
            'id' => $id,
        ]);
    }

    public function delete(int $id): void
    {
        $statement = $this->db->prepare('DELETE FROM products WHERE productID = :id');
        $statement->execute(['id' => $id]);
    }
}
