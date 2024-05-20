# Módulo Magento - Theme Config

Este módulo Magento foi desenvolvido para facilitar a personalização das cores dos botões de classe "primary" em lojas Magento CLI 2.4.7. Ele adiciona um comando no console que permite alterar a cor dos botões primários, diferenciando entre lojas através de seus IDs.

## Instalação

1. Clone este repositório em `app/code/dev/ThemeConfig` dentro da raiz do seu projeto Magento.

 	1.1. Separe os arquivos de tema em `app/design/frontend/DevAlicia/ThemeDefault `.

2. Execute os seguintes comandos no terminal:
   ```
   php bin/magento module:enable DevAlicia_ThemeConfig
   php bin/magento setup:upgrade
   ```

## Uso

Após a instalação e ativação do módulo, você poderá usar o comando `color:primary` no console Magento para alterar a cor dos botões primários. Aqui está a sintaxe do comando:

```
php bin/magento color:primary <color> <store>
```

- `<color>`: A cor desejada para os botões primários. Use valores hexadecimais sem '#', por exemplo, `ff0000` para vermelho.

- `<store>`: O ID da loja para a qual você deseja aplicar a mudança de cor nos botões primários.

## Exemplo de Uso

Para mudar a cor dos botões primários para vermelho na loja com ID 0, você pode executar o seguinte comando:
```
php bin/magento color:primary ff0000 0
```

Após a execução bem-sucedida do comando, os botões primários na loja com ID 1 terão sua cor alterada para vermelho.

## Contribuição

Se você encontrar problemas ou tiver sugestões para melhorias, sinta-se à vontade para abrir uma issue ou enviar um pull request neste repositório.
