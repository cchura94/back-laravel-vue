# Comando GIT
## Descargar e instalar GIT:
- https://git-scm.com/

## Configurar GIT
```
git config --global user.name "John Doe"
git config --global user.email johndoe@example.com
```
------
-----
## Crear un cuenta (GITHUB  |  GITLAB  |  BITBUCKET)
- https://github.com/
- Luego Crear un repositorio GITHUB: https://github.com/
----
- Si ya existe el repositorio (CLONAR)
```
git clone direccion_repo_remoto
```
- Si no existe el repositorio local
## Configuración
### Para Inicializar un nuevo repositorio
```
git init 
```
### Referencia del repositorio local al repositorio remoto

```
git remote add origin https://github.com/cchura94/back-laravel-vue.git

```
---
## Actualizar codigo local con el repositorio remoto
```
git add .
git commit -m "proyecto inicial laravel - crud usuario"
git push origin master
```


