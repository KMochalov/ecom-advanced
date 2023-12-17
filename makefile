init: docker-down-clear docker-pull docker-build docker-up

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

build: build-gateway build-frontend build-api

build-gateway:
	docker --log-level=debug build --pull --file=gateway/docker/prod/nginx/Dockerfile --tag=${REGISTRY}/ecom-gateway:${IMAGE_TAG} gateway/docker

build-frontend:
	docker --log-level=debug build --pull --file=frontend/docker/prod/nginx/Dockerfile --tag=${REGISTRY}/ecom-frontend:${IMAGE_TAG} frontend

build-api:
	docker --log-level=debug build --pull --file=api/docker/prod/php-fpm/Dockerfile --tag=${REGISTRY}/ecom-api-php-fpm:${IMAGE_TAG} api
	docker --log-level=debug build --pull --file=api/docker/prod/nginx/Dockerfile --tag=${REGISTRY}/ecom-api:${IMAGE_TAG} api

try-build:
	REGISTRY=localhost IMAGE_TAG=0 make build


push: push-gateway push-frontend push-api

push-gateway:
	docker push ${REGISTRY}/ecom-gateway:${IMAGE_TAG}

push-frontend:
	docker push ${REGISTRY}/ecom-frontend:${IMAGE_TAG}

push-api:
	docker push ${REGISTRY}/ecom-api:${IMAGE_TAG}
	docker push ${REGISTRY}/ecom-api-php-fpm:${IMAGE_TAG}
