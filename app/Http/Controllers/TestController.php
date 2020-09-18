<?php
class AchievementType
{
    public function name()
    {
        $class = (new Reflection())->getShortName();

        // FirstThousandPoints => First Thousand Points
        return preg_replace('/[A-Z]/', ' $0', $class);
    }

    public function icon()
    {
        return 'first_thousand_point.png';
    }
}

class FirstThousandPoints
{
    public function name()
    {
        return "Fist Thousand Point";
    }

    public function icon()
    {
        return 'first_thousand_point.png';
    }

    public function qualifier($user)
    {
        
    }
}

class FirstBestAnswers
{
    public function name()
    {
        return "Fist best answer";
    }

    public function icon()
    {
        return 'first_best_anwser.png';
    }

    public function qualifier($user)
    {
        
    }
}

$achievement = new AchievementType();

echo($achievement->name());