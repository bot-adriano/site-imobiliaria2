from email import header
from wsgiref import headers
import requests
from bs4 import BeautifulSoup
url = 'https://www.lopes.com.br/busca/aluguel/br/sp/sao-paulo/jardim-franca'

headers = {'User-Agent': "Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36"}

site = requests.get(url, headers=headers)
soup = BeautifulSoup(site.content, 'html.parser')
placas = soup.find_all('div',class_='card__textbox_container')#aqui teremos q inspecionar as paginas e achar oq queremos 
ultima_pagina= soup.find('a', class_ ='page-link ng-star-inserted').get_text().strip() #aqui definimos a ultima pagina

for i in range(1,int(ultima_pagina)):
        url_page = f'https://www.lopes.com.br/busca/aluguel/br/sp/sao-paulo/jardim-franca/rua-gaurama/pagina/{i}'
        site = requests.get(url_page, headers=headers)
soup = BeautifulSoup(site.content, 'html.parser')
placas = soup.find_all('div',class_='card__textbox_container')
#with open('precos_imoveis1.csv','a', newline='', encoding='utf-8') as f : #o 'a' a de append é pra criar uma vez o arquivo e nas proximas vezes nao sobresscrever
with open("precos_imoveis2.csv", "a", newline="", encoding="utf-8") as d :
    for placa in placas:


            #placa = placas[0]
            marca = placa.find('p', class_='card__location').get_text().strip()

            try:
                            preco = placa.find('h5', class_='card__subprice ng-star-inserted').get_text().strip()
                            num_preco = preco[12:]#pra retirar o endereco
            except:
                            num_preco = '0'#caso nao exista valor va ficar em zero
                          #  preco= '0'

            linha = num_preco +';' + marca  + '\n'
            print(linha)
            d.write(linha)
            
           # print(url_page)
# print(preco, endereco,num_marca) 
