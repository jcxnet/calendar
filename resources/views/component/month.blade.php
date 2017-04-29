<?php
    $titleDays = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
    $startDay = $month->getStartDay();
    $endDay = $month->getEndDay();
    $posDay = 0;
?>

<div class="month panel panel-primary">

    <div class="panel-heading">
        <h3 class="month-title panel-title text-center">{{$month->getName()}} {{$month->getYear()}}</h3>
    </div>

    <div class="panel-body">
        <section class="header-days">
            @foreach($titleDays as $titleDay)
                <div class="header-day">{{ substr($titleDay,0,1) }}</div>
            @endforeach
        </section>
        <section class="month-days">
            <div class="month-week">
                @while ($startDay['day'] != $titleDays[$posDay])
                    <div class="month-day day-grey">&nbsp;</div>
				    <?php
				    if($posDay==6){
					    $posDay = 0;
					    echo '</div>';
				    }else{
					    $posDay++;
				    }
				    ?>
                @endwhile
                @for($day=$startDay['number'];$day<=$endDay['number']; $day++)
                    @if($posDay == 0)
                        <div class="month-week">
                            @endif
                            @if( $holiday = $month->getHoliday($day) )
                                <div class="month-day day-holiday">
                                    <a class="day-holiday-link day-tooltip" href="#" title="{!! $holiday !!}">{{$day}}</a>
                                </div>
                            @else
                                <div class="month-day day-{{strtolower($titleDays[$posDay])}}">{{$day}}</div>
                            @endif

						    <?php
						    if($posDay == 6){
							    echo '</div>';
							    $posDay = 0;
						    }else{
							    $posDay++;
						    }
						    ?>
                            @endfor

                            @if($posDay>0)
                                @while($posDay<7)
                                    <div class="month-day day-grey">&nbsp;</div>
								    <?php $posDay++; ?>
                                @endwhile
                        </div>
            @endif
        </section>
    </div>
</div>
