include .env

init: docker-down-clear docker-pull docker-build docker-up api-init

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

restart: down up

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build --pull

api-init: api-composer-install

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-checks: lint-api psalm-api

build: build-gateway build-frontend build-api

build-gateway:
	docker --log-level=debug build --pull --file=gateway/docker/prod/nginx/Dockerfile --tag=${REGISTRY}/ecom-gateway:${IMAGE_TAG} gateway/docker

build-frontend:
	docker --log-level=debug build --pull --file=frontend/docker/prod/nginx/Dockerfile --tag=${REGISTRY}/ecom-frontend:${IMAGE_TAG} frontend

build-api:
	docker --log-level=debug build --pull --file=api/docker/prod/php-fpm/Dockerfile --tag=${REGISTRY}/ecom-api-php-fpm:${IMAGE_TAG} api
	docker --log-level=debug build --pull --file=api/docker/prod/php-cli/Dockerfile --tag=${REGISTRY}/ecom-api-php-cli:${IMAGE_TAG} api
	docker --log-level=debug build --pull --file=api/docker/prod/nginx/Dockerfile --tag=${REGISTRY}/ecom-api:${IMAGE_TAG} api

try-build:
	REGISTRY=localhost IMAGE_TAG=0 make build

lint-api:
	docker-compose run --rm api-php-cli composer lint
	docker-compose run --rm api-php-cli composer cs-check

psalm-api:
	docker-compose run --rm api-php-cli composer psalm

lint-api-csfix:
	docker-compose run --rm api-php-cli composer cs-fix

push: push-gateway push-frontend push-api

push-gateway:
	docker push ${REGISTRY}/ecom-gateway:${IMAGE_TAG}

push-frontend:
	docker push ${REGISTRY}/ecom-frontend:${IMAGE_TAG}

push-api:
	docker push ${REGISTRY}/ecom-api:${IMAGE_TAG}
	docker push ${REGISTRY}/ecom-api-php-fpm:${IMAGE_TAG}

test-api-unit-coverage:
	docker-compose run --rm api-php-cli php vendor/bin/phpunit --color --filter=unit --coverage-html var/coverage

test-api-run-unit:
	docker-compose run --rm api-php-cli php vendor/bin/phpunit --color --filter=unit

test-api-run-all:
	docker-compose run --rm api-php-cli php vendor/bin/phpunit --color

deploy:
	ssh ${HOST} -p ${PORT} 'rm -rf site_${BUILD_NUMBER}'
	ssh ${HOST} -p ${PORT} 'mkdir site_${BUILD_NUMBER}'
	scp -P ${PORT} docker-compose-prod.yml ${HOST}:site_${BUILD_NUMBER}/docker-compose-prod.yml
	ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && echo "COMPOSE_PROJECT_NAME=ecom" >> .env'
	ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && echo "REGISTRY=${REGISTRY}" >> .env'
	ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && echo "IMAGE_TAG=${IMAGE_TAG}" >> .env'
	ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker compose -f docker-compose-prod.yml pull'
	ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker compose -f docker-compose-prod.yml up --build --remove-orphans -d'
	ssh ${HOST} -p ${PORT} 'rm -f site'
	ssh ${HOST} -p ${PORT} 'ln -sr site_${BUILD_NUMBER} site'

rollback:
	ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker compose -f docker-compose-prod.yml pull'
	ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker compose -f docker-compose-prod.yml up --build --remove-orphans -d'
	ssh ${HOST} -p ${PORT} 'rm -f site'
	ssh ${HOST} -p ${PORT} 'ln -sr site_${BUILD_NUMBER} site'
