# ecom-advanced

Деплой на сервер:

Выполнить из папки provisioning
ansible-playbook -i hosts.yml site.yml

Выполнить из папки provisioning
ansible-playbook -i hosts.yml docker-login.yml

Сбилдить контейнеры
Выполнить из корня make build

запушить всё на сервер:
make deploy
