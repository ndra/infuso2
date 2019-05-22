<?

$cell = $battery->cell();

<div class='XZpFQxStUo' >

    <div style='font-family: monotype;' >
        //<div style='margin-right: 20px;' >
            <div>U<sub>ном.</sub> = {$cell->nominalVoltage()} В</div>
            <div>U<sub>мин.</sub> = {$cell->minVoltage()} В</div>
            <div>U<sub>макс.</sub> = {$cell->maxVoltage()} В</div>
            <div>P<sub>E</sub> = { round($cell->energyDensity())} Вт*ч/кг.</div>
        //</div>
        //<div style='white-space: nowrap;' >
            <div>C<sub>ном.</sub> = {$cell->nominalCapacity()} А*ч</div>
            <div>I<sub>макс.</sub> = {$cell->maxContinuousCurrentDischarge()} А</div>
            <div>C<sub>1/2 I <sub>макс.</sub></sub> = {round($cell->capacityAh($cell->maxContinuousCurrentDischarge() / 2), 2)} А*ч</div>
            <div>r<sub>внутр</sub> = {$cell->data("internalResistance")} мОм</div>
        //</div>
    </div>
    
  //  <br/>
   // <div>Циклов до 70% номинальной емкости: {$cell->cycles()}</div>

</div>