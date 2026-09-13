<?php

/*Alunos Bruno Aparecido e Igor Nogueira*/
declare(strict_types=1);

namespace DesignPatterns\Structural\Adapter;

/**
 * Classe feita na atividade.
 * Implementa a interface Book (Target), é essa implementação que resolve
 * a incompatibilidade: o cliente continua programando contra Book,
 * sem saber que por trás existe um Kindle (EBook).
 */
class EBookAdapter implements Book
{
    /**
     * Composição, o Adapter recebe uma instância de EBook
     * via injeção de dependência no construtor. Isso é o que permite adaptar
     * QUALQUER classe que implemente EBook sem reescrever o Adapter.
     * A propriedade é declarada direto no construtor.
     */
    public function __construct(protected EBook $eBook)
    {
    }

    /**
     * Tradução de chamada 1: o cliente chama open() (método do contrato Book),
     * e o Adapter internamente traduz para unlock() (método real do EBook/Kindle).
     * Nenhuma lógica nova é criada aqui — só o "de-para" de nomes.
     */
    public function open()
    {
        $this->eBook->unlock();
    }

    /**
     * Tradução de chamada 2: turnPage() (Book) -> pressNext() (EBook).
     * Mesma ideia: delega para o método equivalente do objeto adaptado.
     */
    public function turnPage()
    {
        $this->eBook->pressNext();
    }

    /**
     * Aqui é a adaptação de TIPO de retorno.
     * - Book::getPage() precisa devolver int (página atual).
     * - EBook::getPage() devolve array, ex.: [10, 100] = página 10 de 100.
     * A criação nova aqui é o [0]: pego só o primeiro item do array
     * (a página atual) para cumprir exatamente o que Book espera.
     * Sem essa linha, o retorno seria incompatível e daria erro de tipo.
     */
    public function getPage(): int
    {
        return $this->eBook->getPage()[0];
    }
}