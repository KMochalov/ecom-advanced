init:
	down-clear pull build up

up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

down-clear:
	docker-compose down -v --remove-orphans

restart:
	down up

pull:
	docker-compose pull

build:
	docker-compose build --pull
