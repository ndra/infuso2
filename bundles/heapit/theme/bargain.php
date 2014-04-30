<?
 
title("Сделка «{$bargain->org()->title()}»");
tmp::param("main-menu","bargains");
add("center","content");
add("right","right-tabs");
exec("/heapit/layout");