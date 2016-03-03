<?php

use Illuminate\Database\Seeder;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipesTitle = [
                            'Crepes alla nutella',
                            'Risotto al pepe Rosa',
                            'Budino alla fragola',
                            'Farfalle al sugo d\'arrosto',
                            'Milanese di pollo con patate'
                        ];
        $recipesProcedure = [
                                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin nec nulla eu neque facilisis eleifend. Donec tristique elementum ligula, et tempor eros tincidunt sit amet. Nam vitae convallis risus. Nunc aliquam, diam ac volutpat egestas, lacus eros blandit massa, ut congue leo erat vel lacus. Donec id varius ex, nec sollicitudin ligula. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin quis velit ac enim congue mollis. Quisque non est vitae dolor iaculis bibendum id quis lacus. Nullam velit nisi, porttitor ac finibus eget, mattis eu velit. Morbi mattis mattis arcu, at mattis odio sagittis suscipit. Maecenas ultricies enim ex, non aliquet enim convallis eget. Vestibulum pellentesque dignissim nisl et cursus. Sed at mi quis dolor rhoncus rhoncus. Quisque eu molestie nunc.',
                                'Quisque sodales massa iaculis viverra tincidunt. Mauris porta mollis vehicula. Pellentesque congue porttitor est ut volutpat. Donec at nisl non massa euismod egestas. Suspendisse potenti. Suspendisse convallis mi sed velit blandit, at congue purus vestibulum. Nunc laoreet quis orci vitae ultrices. Praesent pellentesque mauris in sollicitudin auctor. Morbi at venenatis sapien. Nullam tempus dui elit, quis eleifend quam sodales ut. Curabitur mi augue, aliquet id egestas dignissim, lobortis et mauris. Nulla facilisi. Proin rutrum, arcu quis egestas dignissim, mauris massa posuere metus, sit amet suscipit velit felis quis neque. Vestibulum molestie nunc sit amet sapien egestas facilisis. Sed non nulla sit amet nibh ullamcorper consequat. Fusce elementum sodales diam id vehicula.',
                                'Proin lacinia quam vehicula dolor egestas, quis dapibus nisi viverra. Mauris sagittis neque sed erat porttitor malesuada. Duis lectus odio, mollis eu velit in, fringilla iaculis augue. Suspendisse vitae turpis elit. Mauris faucibus aliquam dictum. Vestibulum rhoncus orci elit, et faucibus ex mattis et. Sed mauris lectus, pellentesque eget hendrerit a, mattis eget erat. In at massa ut urna commodo hendrerit. Cras tincidunt nibh vel nisi congue, sit amet vehicula nisl varius.',
                                'Etiam bibendum, erat in maximus ornare, arcu magna mattis augue, a aliquam massa ante in tortor. Cras in libero diam. Fusce orci neque, vulputate ut neque eu, pulvinar cursus leo. Integer gravida augue orci, vitae posuere mi dignissim eu. Nullam sollicitudin non sem id condimentum. Fusce non pretium mi, id tristique lorem. Donec laoreet purus a justo hendrerit interdum. Vivamus id justo et ligula lobortis feugiat sed ut lorem. Nunc nec vulputate justo, accumsan mattis ex. Duis luctus risus eget augue suscipit, nec tristique ligula malesuada. Donec augue lorem, sagittis quis rutrum eget, congue nec magna.',
                                'Suspendisse potenti. Vestibulum tempus fringilla justo in porttitor. Phasellus pellentesque lacus ut mauris sagittis consequat. Donec iaculis tristique lobortis. Integer lorem metus, sollicitudin in egestas ac, egestas in nulla. Aenean tempor nisl non nulla auctor, sit amet auctor felis viverra. Donec at sapien neque. Nulla erat sapien, venenatis et augue mattis, gravida laoreet erat. Quisque at ante in sapien semper congue eu lobortis nulla. Phasellus efficitur ut nisl vehicula ullamcorper. Fusce posuere eros eu blandit fermentum. Morbi leo odio, venenatis at congue eget, mollis ac arcu.'
                            ];
        $recipesUser = [1,1,2,3,5];
        
        $recipes = [$recipesTitle,$recipesProcedure,$recipesUser];

        for($i = 0; $i<5;$i++){
            DB::table('recipes')->insert([
               'title' => $recipes[0][$i],
               'procedure' => $recipes[1][$i],
               'user_id' => $recipes[2][$i],
            ]);
        }
    }
}
