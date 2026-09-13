# Atividade — Padrão de Projeto Adapter (Structural/Adapter)

Alunos - Bruno Aparecido e Igor Nogueira

## 1. Clonagem do repositório

```bash
git clone https://github.com/Bruno-Aparecido-Rodrigues/Padrao-de-modelagem-adapter-PHP
cd Padrao-de-modelagem-adapter-PHP
```

## 2. Instalar dependência

```bash
composer install
```

## 3. Mapeamento do domínio (`Structural/Adapter`)

| Componente | Papel no padrão | Descrição |
|---|---|---|
| `Book` (interface) | Target | Contrato esperado pelo cliente: `open()`, `turnPage()` e `getPage(): int`. |
| `PaperBook` | Implementação concreta do Target | Livro tradicional que já atende `Book` diretamente. |
| `EBook` (interface) | Adaptee | Subsistema externo com nomenclatura própria: `unlock()`, `pressNext()` e `getPage(): array` (retorna página atual e total de páginas, ex.: `[10, 100]`). |
| `Kindle` | Adaptee concreto | Simula um leitor digital de terceiros que implementa `EBook`, incompatível com `Book`. |
| `EBookAdapter` | **Adapter** | Classe construída nesta atividade — traduz `EBook` para `Book`. |
| `Tests/AdapterTest.php` | Teste | Valida `PaperBook` e `EBookAdapter` através do mesmo contrato `Book`. |

## 4. Identificação do conflito

O código cliente conhece apenas a interface `Book`. Uma instância de `Kindle` não pode ser entregue a esse cliente diretamente, porque:

- `Book::open()` ↔ `EBook::unlock()` — nomes diferentes;
- `Book::turnPage()` ↔ `EBook::pressNext()` — nomes diferentes;
- `Book::getPage(): int` ↔ `EBook::getPage(): array` — tipos de retorno incompatíveis.

## 5. Validação

Com o adapter, o cliente passa a usar `Kindle` como se fosse um `Book` comum:

```php
use \Structural\Adapter\Kindle;
use \Structural\Adapter\EBookAdapter;

$kindle = new Kindle();
$book = new EBookAdapter($kindle);

$book->open();
$book->turnPage();

echo $book->getPage(); // 2
```

Os testes automatizados do próprio repositório (`Tests/AdapterTest.php`) cobrem esse cenário e podem ser executados com:

```bash
php -d error_reporting=E_ALL^E_DEPRECATED vendor/bin/phpunit Structural/Adapter/Tests/AdapterTest.php
```

## 7. Estrutura final do diretório

```
Padrao-de-modelagem-adapter-PHP/
└── Structural/
    └── Adapter/
        ├── Book.php
        ├── PaperBook.php
        ├── EBook.php
        ├── Kindle.php
        ├── EBookAdapter.php   <-- arquivo feito na atividade
        └── Tests/
            └── AdapterTest.php
```