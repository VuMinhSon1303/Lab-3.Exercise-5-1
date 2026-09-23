<?php

class CategoryModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $statement = $this->db->query('SELECT categoryID, categoryName FROM categories ORDER BY categoryName');
        return $statement->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $statement = $this->db->prepare('SELECT categoryName FROM categories WHERE categoryID = :id');
        $statement->execute(['id' => $id]);
        $category = $statement->fetch();
        return $category ?: null;
    }

    public function add(string $categoryName): void
    {
        $statement = $this->db->prepare('INSERT INTO categories (categoryName) VALUES (:category_name)');
        $statement->execute(['category_name' => $categoryName]);
    }

    public function addCategory(string $categoryName): void
    {
        $this->add($categoryName);
    }

    public function update(int $id, string $categoryName): void
    {
        $statement = $this->db->prepare('UPDATE categories SET categoryName = :category_name WHERE categoryID = :id');
        $statement->execute(['category_name' => $categoryName, 'id' => $id]);
    }

    public function delete(int $id): void
    {
        $statement = $this->db->prepare('DELETE FROM categories WHERE categoryID = :id');
        $statement->execute(['id' => $id]);
    }

    public function deleteCategory(int $id): void
    {
        $this->delete($id);
    }

    public function getCategoryList(): array
    {
        return $this->getAll();
    }
}
