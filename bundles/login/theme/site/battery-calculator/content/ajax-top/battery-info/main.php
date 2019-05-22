<?

$battery->setPower(278);

<div class='cznMzGZCFz' >
    <div class='item' >Запас хода: {round($battery->range(30))} км</div>
    <div class='item' style='display: flex; align-items: center;'  >
        <div style='flex: 0; margin-right: 10px; padding-right: 10px; border-right: 1px solid #ccc; white-space: nowrap;' >Емкость<br>(30 км/ч):</div>
        <div>
            <div>{round($battery->capacity() / 1000, 2)} кВт*ч</div>
            <div>{round($battery->capacityAH(), 2)} А*ч</div>
        </div>
    </div>
    <div class='item' >Вес: {round($battery->weight(), 2)} кг</div>
    <div class='item' >Напряжение: {round($battery->nominalVoltage(),2)} В</div>
    <div class='item' >Макс. мощность: {round($battery->maxContinuousPower() / 1000, 1)} кВт</div>
    
    
</div>