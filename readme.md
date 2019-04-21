## Prueba Agence

La prueba fue desarrollada bajo los requerimientos solicitados utilizando para ello:

- [PHP Laravel Framework v5.8.11](https://www.laravel.com)
- [Vuetify Progressive Framework v2.0.0-alpha.16](https://next.vuetify.com)
- [Vue JS Framework v2.5.17](https://vuejs.org)
- [Highcharts v7.1.1](https://www.highcharts.com)
- [MomentJS v2.24.0](http://www.momentjs.com)
- [Material Design Icons v3.5.95](https://materialdesignicons.com)
- [Lodash v4.17.11 ](https://lodash.com/)
- [Axios v0.18](https://github.com/axios/axios)

Fueron también utilizados los siguientes componentes Vue.
- [highcharts-vue v5.8.11](https://github.com/highcharts/highcharts-vue#readme)
- [vue-numeral-filter](https://github.com/lloydjatkinson/vue-numeral-filter#readme)

## Explicación en Laravel
Se utilizó un controlador app\Http\Controllers\AgenceController, se agregó un archivo de configuración config\agence.php para el versionado de la aplicación Javascript y CSS (JC_VERSION), una vista resources\views\index.blade.php y una platilla (layout) resources\views\layouts\master.blade.php

Se agregaron 3 rutas (routes\web.php) GET /, POST /relatorio, POST /pizza, POST /grafico

Fue agregada una migración de datos donde se incluyeron 2 vistas de base de datos: v_relatorio y v_pizza.

### Base de datos
En el momento de la carga de la base de datos fue detectado y corregido un error del script SQL enviado.

#### Scripts de las vistas requeridas en el proyecto.

CREATE OR REPLACE VIEW `v_relatorio` AS select s.co_usuario,DATE_FORMAT(f.data_emissao,"%Y-%m") period,sum(f.valor-(f.valor*total_imp_inc/100)) recliq,IFNULL((select brut_salario from cao_salario where co_usuario=s.co_usuario),0) bruto,sum((valor-(valor*total_imp_inc/100))*(comissao_cn/100)) comision from cao_fatura f, cao_os s where f.co_os=s.co_os group by s.co_usuario,period

CREATE OR REPLACE VIEW `v_pizza` AS select s.co_usuario,DATE_FORMAT(f.data_emissao,'%Y-%m') period,round(sum(f.valor-(f.valor*total_imp_inc/100)),2) recliq from cao_fatura f, cao_os s where f.co_os=s.co_os group by s.co_usuario,period
 

## Javascript y CSS del proyecto

Se utilizó laravel-mix para la compresión y optimización de los archivos Javascript y CSS generando la estructura de directorio public\assets requerida para el proyecto.

## Bugs

Fueron detectados dos bugs en el componente v-data-table del Framework Vuetify en el checkbox de seleccionar todos los registros y el ordenamiento, los mismo ya habían sido notificados.

## Seguridad

No fue utilizado el token de seguridad CSRF por no ser requerido en esta prueba.

## Hospedaje

La solución será hospedada próximamente para que realicen las pruebas de performance y funcionalidad de la prueba.

## Pasos para un Despliegue local

- 