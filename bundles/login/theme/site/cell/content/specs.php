<?

<div style='display: flex;' >
    <div style='margin-right: 30px;' >
        <div>U<sub>ном.</sub> = {$cell->nominalVoltage()} В</div>
        <div>U<sub>мин.</sub> = {$cell->minVoltage()} В</div>
        <div>U<sub>макс.</sub> = {$cell->maxVoltage()} В</div>
    </div>
    <div style='white-space: nowrap;' >
        <div>C<sub>ном.</sub> = {$cell->nominalCapacity()} А*ч</div>
        <div>C<sub>1/2 I max.</sub> = {round($cell->capacityAh($cell->maxContinuousCurrentDischarge() / 2), 2)} А*ч</div>
        <div>I<sub>макс.</sub> = {$cell->maxContinuousCurrentDischarge()} А</div>
        
        <div>P<sub>E</sub> = { round($cell->energyDensity())} Вт*ч/кг.</div>
        <div>r<sub>внутр</sub> = {$cell->data("internalResistance")} мОм</div>
    </div>
</div>

if($spec = $cell->data("spec")) {
    <br>
    <a href='{$spec}' >Спецификация ({\Infuso\Core\File::get($spec)->ext()})</a>
}

<br>
echo "Химия: <a href='{$cell->chemistry()->url()}' >{$cell->chemistry()->title()}</a>";