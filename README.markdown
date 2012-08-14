# Cogem 1.0

Plugin que facilita o controle de exibição das mensagens do sistema. Foi desenvolvido exclusivamente para sistemas em português, para gerênciar palavras/mensagens de gênero feminino e masculino.

## Compatibilidade

Compatível com CakePHP v 1.3

# Instalação

Faça o download do plugin e coloque seu conteúdo dentro de `/app/plugins/cogem` ou em outro diretório para plugins do CakePHP.

Edite o arquivo __/app/app_controller.php__:

<pre>
var $components = array(
    'Session',       
    'Cogem.Cogem'
);
</pre>

# Utilização

Você pode chamar as funções do Cogem no Controler usando __$this->Cogem__ e na View a variável __$Cogem__.

## Configurando as Inflexões

Algumas palavras já foram previamente configuradas no plugin para utilização. Entretanto, você DEVE definir a inflexão `item` e outras - se você desejar - em seu Controller.

Ao definir uma inflexão, podemos informar sua versão no `singular` e `plural`. Caso a sua versão em plural não seja informada, ou vice-versa, o plugin utilizará a regra do Inflector do CakePHP para realizar a conversão.

Exemplo 1:

<pre>
function beforeFilter()
{
    
    $this->Cogem->setInflections(
        array(
            'item' => array(
                'singular' => __('fabricante', true),
                'plural'   => __('fabricantes', true)
            )
        )
    );
    
}
</pre>

Exemplo 2, agora o `item` tem o gênero feminino, então alteramos todos os parâmetros pré-definidos:

<pre>
function beforeFilter()
{
    
    $this->Cogem->setInflections(
        array(
            'item' => array(
                'singular' => __('concessionária', true)
            ),
            
            /**
             * Definições personalizadas
             */  
            'new' => array(
                'singular' => __('nova', true)
            ),
            'view' => array(
                'singular' => __('exibida', true)
            ),
            'add' => array(
                'singular' => __('adicionada', true)
            ),
            'edit' => array(
                'singular' => __('editada', true)
            ),
            'delete' => array(
                'singular' => __('excluída', true)
            ),
            'selected' => array(
                'singular' => __('selecionada', true)
            ),
            'finded' => array(
                'singular' => __('encontrada', true)
            ),
            'the' => array(
                'singular' => __('a', true)
            ),
            'a' => array(
                'singular' => __('uma', true)
            ),
            'no' => array(
                'singular' => __('nenhuma', true)
            )
        )
    );
    
}
</pre>

## Configurando as Mensagens

Assim como as inflexões, o plugin conta também com algumas mensagens pré-definidas para utilização. Contudo, você também pode configurar mensagens diferentes para sua aplicação.

Na declaração com componente, basta informar as mensagens e nelas coloca nas mensagens entre `{ }` a inflexão que você deseja exibir. Você também pode utilizar `{ucfirst{ }}` para que o comando `ucfirst()` seja executado.

<pre>
var $components = array(
    'Session',
    'Cogem.Cogem' => array(
    	'messages' => array(
    		'add' => array(
                'success' => '{ucfirst{item}} #{id} foi {add}.',
                'error'   => 'Não foi possível adicionar {the} {item}.'
            ),
            'edit' => array(
                'failure' => '{ucfirst{item}} não pode ser {edit}.',
                'success' => '{ucfirst{item}} #{id} foi {edit}.',
                'error'   => 'Não foi possível editar {the} {item} #{id}.'
            ),
            'delete' => array(
                'failure' => '{ucfirst{item}} não pode ser {delete}.',
                'success' => '{ucfirst{item}} #{id} foi {delete}.',
                'error'   => 'Não foi possível excluir {the} {item} #{id}.'
            ),
            'log' => array(
                'add'    => __('{ucfirst{item}} #{id} foi {add}.', true),
                'edit'   => __('{ucfirst{item}} #{id} foi {edit}.', true),
                'delete' => __('{ucfirst{item}} #{id} foi {delete}.', true)
            ),
            'view' => array(
                'failure' => '{ucfirst{item}} não pode ser {view}.'
            ),
            'parent' => array(
                'error' => '{ucfirst{no}} {parent} foi {finded}. Você precisa cadastrar primeiro {a} {parent}.'
            )
    	)
    )
);
</pre>

# Funções

Podemos utilizar duas funções para exibir as mensagens com as inflexões: `getMessage()` e `writeMessage()`.

## getMessage()

Para exibir as mensagens pré-definidas utilizamos a função `getMessage()`, passando no mínimo dois parâmetros:

*  __1º:__ Tipo da mensagem;
*  __2º:__ A mensagem específica;
*  __3º (opcional):__ `singular` ou `plural`. Se não informado será `singular`.
*  __4º (opcional):__ O conteúdo da inflexão `{id}`. 

Exemplo 1:

<pre>
$this->Cogem->getMessage('add', 'error');
// Retorna: "Não foi possível adicionar o fabricante."

$this->Cogem->getMessage('edit', 'error', 'plural');
// Retorna: "Não foi possível editar os fabricantes."

$this->Cogem->getMessage('delete', 'success', 'singular', 2);
// Retorna: "Fabricante #2 foi excluído."
</pre>

Exemplo 2:

<pre>
$this->Cogem->getMessage('add', 'error');
// Retorna: "Não foi possível adicionar a concessionária."

$this->Cogem->getMessage('edit', 'error', 'plural');
// Retorna: "Não foi possível editar as concessionárias."

$this->Cogem->getMessage('delete', 'success', 'singular', 110);
// Retorna: "Concessionária #110 foi excluída."
</pre>

## writeMessage()

Você pode escrever uma mensagem sem pré-definilá no plugin, utilizando a função `writeMessage()`, passando no mínimo um parâmetro:

*  __1º:__ A mensagem;
*  __2º (opcional):__ `singular` ou `plural`. Se não informado será `singular`.
*  __3º (opcional):__ O conteúdo da inflexão `{id}`.

Exemplo 1:

<pre>
$this->Cogem->writeMessage('{ucfirst{no}} {item} foi {finded}.');
// Retorna: "Nenhum fornecedor foi encontrado."

$this->Cogem->writeMessage('{id} {item} {selected}.', 'plural', 10);
// Retorna: "10 fornecedores selecionados."
</pre>

Exemplo 2:

<pre>
$this->Cogem->writeMessage('{ucfirst{no}} {item} foi {finded}.');
// Retorna: "Nenhuma concessionária foi encontrada."

$this->Cogem->writeMessage('{id} {item} {selected}.', 'plural', 10);
// Retorna: "10 concessionárias selecionadas."
</pre>

## getInflection()

Você pode pegar uma palavra individual através da função `getInflection()`, passando no mínimo um parâmetro:

*  __1º:__ A inflexão;
*  __2º (opcional):__ `singular` ou `plural`. Se não informado será `singular`.

Exemplo 1:

<pre>
echo $this->Cogem->getInflection('item');
// Retorna: "fornecedor"

echo $this->Cogem->getInflection('item', 'plural');
// Retorna: "fornecedores"
</pre>

Exemplo 2:

<pre>
echo $this->Cogem->getInflection('item');
// Retorna: "concessionária"

echo $this->Cogem->getInflection('item', 'plural');
// Retorna: "concessionárias"
</pre>

# Copyright e Licença

Copyright 2011, Pedro Elsner (http://pedroelsner.com/)

Licenciado pela Creative Commons 3.0 (http://creativecommons.org/licenses/by/3.0/br/)