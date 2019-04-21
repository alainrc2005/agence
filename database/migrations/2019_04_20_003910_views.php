<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Views extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE OR REPLACE VIEW `v_relatorio` AS select s.co_usuario,DATE_FORMAT(f.data_emissao,"%Y-%m") period,sum(f.valor-(f.valor*total_imp_inc/100)) recliq,IFNULL((select brut_salario from cao_salario where co_usuario=s.co_usuario),0) bruto,sum((valor-(valor*total_imp_inc/100))*(comissao_cn/100)) comision from cao_fatura f, cao_os s where f.co_os=s.co_os group by s.co_usuario,period');
        DB::unprepared('CREATE OR REPLACE VIEW `v_pizza` AS select s.co_usuario,DATE_FORMAT(f.data_emissao,\'%Y-%m\') period,round(sum(f.valor-(f.valor*total_imp_inc/100)),2) recliq from cao_fatura f, cao_os s where f.co_os=s.co_os group by s.co_usuario,period');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS `v_pizza`');
        DB::unprepared('DROP VIEW IF EXISTS `v_relatorio`');
    }
}
