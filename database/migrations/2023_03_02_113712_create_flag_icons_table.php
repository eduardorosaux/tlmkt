<?php

use App\Models\FlagIcon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('flag_icons')) {
            Schema::create('flag_icons', function (Blueprint $table) {
                $table->id();
                $table->string('image', 50);
                $table->string('title', 10);
                $table->timestamps();
            });

            $flags = [
                ['image' => 'images/flags/ad.png', 'title' => 'AD', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ae.png', 'title' => 'AE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/af.png', 'title' => 'AF', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ag.png', 'title' => 'AG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ai.png', 'title' => 'AI', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/al.png', 'title' => 'AL', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/am.png', 'title' => 'AM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ao.png', 'title' => 'AO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ar.png', 'title' => 'AR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/as.png', 'title' => 'AS', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/at.png', 'title' => 'AT', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/au.png', 'title' => 'AU', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/aw.png', 'title' => 'AW', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ax.png', 'title' => 'AX', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/az.png', 'title' => 'AZ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ba.png', 'title' => 'BA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bb.png', 'title' => 'BB', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bd.png', 'title' => 'BD', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/be.png', 'title' => 'BE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bf.png', 'title' => 'BF', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bg.png', 'title' => 'BG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bh.png', 'title' => 'BH', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bi.png', 'title' => 'BI', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bj.png', 'title' => 'BJ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bm.png', 'title' => 'BM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bn.png', 'title' => 'BN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bo.png', 'title' => 'BO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/br.png', 'title' => 'BR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bs.png', 'title' => 'BS', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bt.png', 'title' => 'BT', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bv.png', 'title' => 'BV', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bw.png', 'title' => 'BW', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/by.png', 'title' => 'BY', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/bz.png', 'title' => 'BZ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ca.png', 'title' => 'CA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cc.png', 'title' => 'CC', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cd.png', 'title' => 'CD', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cf.png', 'title' => 'CF', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cg.png', 'title' => 'CG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ch.png', 'title' => 'CH', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ci.png', 'title' => 'CI', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ck.png', 'title' => 'CK', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cl.png', 'title' => 'CL', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cm.png', 'title' => 'CM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cn.png', 'title' => 'CN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/co.png', 'title' => 'CO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cr.png', 'title' => 'CR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cv.png', 'title' => 'CV', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cv.png', 'title' => 'CV', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cx.png', 'title' => 'CX', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cy.png', 'title' => 'CY', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/cz.png', 'title' => 'CZ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/de.png', 'title' => 'DE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/dj.png', 'title' => 'DJ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/dk.png', 'title' => 'DK', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/dm.png', 'title' => 'DM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/do.png', 'title' => 'DO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/dz.png', 'title' => 'DZ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ec.png', 'title' => 'EC', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ee.png', 'title' => 'EE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/eg.png', 'title' => 'EG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/eh.png', 'title' => 'EH', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/er.png', 'title' => 'ER', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/es.png', 'title' => 'ES', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/et.png', 'title' => 'ET', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/fi.png', 'title' => 'FI', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/fj.png', 'title' => 'FJ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/fk.png', 'title' => 'FK', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/fm.png', 'title' => 'FM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/fo.png', 'title' => 'FO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/fr.png', 'title' => 'FR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ga.png', 'title' => 'GA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gb.png', 'title' => 'GB', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gd.png', 'title' => 'GD', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ge.png', 'title' => 'GE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gf.png', 'title' => 'GF', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gh.png', 'title' => 'GH', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gi.png', 'title' => 'GI', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gl.png', 'title' => 'GL', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gm.png', 'title' => 'GM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gn.png', 'title' => 'GN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gn.png', 'title' => 'GN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gp.png', 'title' => 'GP', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gq.png', 'title' => 'GQ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gr.png', 'title' => 'GR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gs.png', 'title' => 'GS', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gt.png', 'title' => 'GT', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gu.png', 'title' => 'GU', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gw.png', 'title' => 'GW', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/gy.png', 'title' => 'GY', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/hk.png', 'title' => 'HK', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/hm.png', 'title' => 'HM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/hn.png', 'title' => 'HN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/hr.png', 'title' => 'HR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ht.png', 'title' => 'HT', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/hu.png', 'title' => 'HU', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/id.png', 'title' => 'ID', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ie.png', 'title' => 'IE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/il.png', 'title' => 'IL', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/in.png', 'title' => 'IN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/io.png', 'title' => 'IO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/iq.png', 'title' => 'IQ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ir.png', 'title' => 'IR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/is.png', 'title' => 'IS', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/it.png', 'title' => 'IT', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/jm.png', 'title' => 'JM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/jo.png', 'title' => 'JO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/jp.png', 'title' => 'JP', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ke.png', 'title' => 'KE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/kg.png', 'title' => 'KG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/kh.png', 'title' => 'KH', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ki.png', 'title' => 'KI', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/km.png', 'title' => 'KM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/kn.png', 'title' => 'KN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/kp.png', 'title' => 'KP', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/kr.png', 'title' => 'KR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/kw.png', 'title' => 'KW', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ky.png', 'title' => 'KY', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/kz.png', 'title' => 'KZ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/la.png', 'title' => 'LA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/lb.png', 'title' => 'LB', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/lc.png', 'title' => 'LC', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/li.png', 'title' => 'LI', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/lk.png', 'title' => 'LK', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/lr.png', 'title' => 'LR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ls.png', 'title' => 'LS', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/lt.png', 'title' => 'LT', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/lu.png', 'title' => 'LU', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/lv.png', 'title' => 'LV', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ly.png', 'title' => 'LY', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ma.png', 'title' => 'MA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mc.png', 'title' => 'MC', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/md.png', 'title' => 'MD', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/me.png', 'title' => 'ME', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mg.png', 'title' => 'MG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mh.png', 'title' => 'MH', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mk.png', 'title' => 'MK', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ml.png', 'title' => 'ML', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mm.png', 'title' => 'MM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mn.png', 'title' => 'MN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mo.png', 'title' => 'MO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mp.png', 'title' => 'MP', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mq.png', 'title' => 'MQ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mr.png', 'title' => 'MR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ms.png', 'title' => 'MS', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mt.png', 'title' => 'MT', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mu.png', 'title' => 'MU', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mv.png', 'title' => 'MV', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mw.png', 'title' => 'MW', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mx.png', 'title' => 'MX', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/my.png', 'title' => 'MY', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/mz.png', 'title' => 'MZ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/na.png', 'title' => 'NA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/nc.png', 'title' => 'NC', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ne.png', 'title' => 'NE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/nf.png', 'title' => 'NF', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ng.png', 'title' => 'NG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ni.png', 'title' => 'NI', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/nl.png', 'title' => 'NL', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/no.png', 'title' => 'NO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/np.png', 'title' => 'NP', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/nr.png', 'title' => 'NR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/nu.png', 'title' => 'NU', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/nz.png', 'title' => 'NZ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/om.png', 'title' => 'OM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/pa.png', 'title' => 'PA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/pe.png', 'title' => 'PE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/pf.png', 'title' => 'PF', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/pg.png', 'title' => 'PG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ph.png', 'title' => 'PH', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/pk.png', 'title' => 'PK', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/pl.png', 'title' => 'PL', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/pm.png', 'title' => 'PM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/pn.png', 'title' => 'PN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/pr.png', 'title' => 'PR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ps.png', 'title' => 'PS', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/pt.png', 'title' => 'PT', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/pw.png', 'title' => 'PW', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/py.png', 'title' => 'PY', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/qa.png', 'title' => 'QA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/re.png', 'title' => 'RE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ro.png', 'title' => 'RO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/rs.png', 'title' => 'RS', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ru.png', 'title' => 'RU', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/rw.png', 'title' => 'RW', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sa.png', 'title' => 'SA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sb.png', 'title' => 'SB', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sc.png', 'title' => 'SC', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sd.png', 'title' => 'SD', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/se.png', 'title' => 'SE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sg.png', 'title' => 'SG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sh.png', 'title' => 'SH', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/si.png', 'title' => 'SI', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sj.png', 'title' => 'SJ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sk.png', 'title' => 'SK', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sl.png', 'title' => 'SL', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sm.png', 'title' => 'SM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sn.png', 'title' => 'SN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/so.png', 'title' => 'SO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sr.png', 'title' => 'SR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/st.png', 'title' => 'ST', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sv.png', 'title' => 'SV', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sy.png', 'title' => 'SY', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/sz.png', 'title' => 'SZ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tc.png', 'title' => 'TC', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/td.png', 'title' => 'TD', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tf.png', 'title' => 'TF', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tg.png', 'title' => 'TG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/th.png', 'title' => 'TH', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tj.png', 'title' => 'TJ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tk.png', 'title' => 'TK', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tl.png', 'title' => 'TL', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tm.png', 'title' => 'TM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tn.png', 'title' => 'TN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/to.png', 'title' => 'TO', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tr.png', 'title' => 'TR', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tt.png', 'title' => 'TT', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tv.png', 'title' => 'TV', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tw.png', 'title' => 'TW', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/tz.png', 'title' => 'TZ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ua.png', 'title' => 'UA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/us.png', 'title' => 'US', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ug.png', 'title' => 'UG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/um.png', 'title' => 'UM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/uy.png', 'title' => 'UY', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/uz.png', 'title' => 'UZ', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/va.png', 'title' => 'VA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/vc.png', 'title' => 'VC', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ve.png', 'title' => 'VE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/vg.png', 'title' => 'VG', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/vi.png', 'title' => 'VI', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/vn.png', 'title' => 'VN', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/vu.png', 'title' => 'VU', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/wf.png', 'title' => 'WF', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ws.png', 'title' => 'WS', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/ye.png', 'title' => 'YE', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/yt.png', 'title' => 'YT', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/za.png', 'title' => 'ZA', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/zm.png', 'title' => 'ZM', 'created_at' => now(), 'updated_at' => now()],
                ['image' => 'images/flags/zw.png', 'title' => 'ZW', 'created_at' => now(), 'updated_at' => now()],
            ];

            FlagIcon::insert($flags);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flag_icons');
    }
};