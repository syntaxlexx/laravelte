<?php

namespace App\Actions\Frontend;

use App\Traits\CustomControllerResponsesTrait;
use App\Traits\ThemesTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class PolicyPages
{
    use AsAction;
    use ThemesTrait;
    use CustomControllerResponsesTrait;

    public function asController(Request $request, $slug = 'privacy-policy')
    {
        // TODO: fetch privacy policy
        return $this->generatePage('privacy-policy', 'PrivacyPolicy', [
            'title' => 'Privacy Policy',
            'slug' => $slug,
            'content' => $this->getDemoContent(),
            'updated_at' => now()->subMonths(20),
        ]);

    }

    public function getDemoContent() : string {
        return "
        <p>Ac, nec lacinia excepteur iaculis molestie facere lacus, nulla nunc duis consectetuer corporis posuere minima corrupti velit culpa rutrum vestibulum? Tenetur erat. Blanditiis repudiandae tempora laudantium natoque purus fringilla eveniet quam egestas? Penatibus corrupti, voluptatum, pharetra, viverra irure tempora felis sapiente velit eget tincidunt? Aptent, aenean! Quidem eaque nonummy vulputate quos necessitatibus occaecati ullamco mollis illum praesentium suspendisse esse odio, odio ex cupidatat aliquet quae occaecati per quasi ipsam illum, unde! Animi nascetur nunc inventore. Anim, diamlorem asperiores! Nulla temporibus. Magni fermentum metus natoque, tempus augue sociis gravida curae netus? Risus consequat quisquam netus habitasse nec faucibus tortor eligendi, dictumst.</p>

<p>Arcu nunc et eveniet sociis hendrerit! Mauris, maiores, consectetuer sapien, sociis rhoncus dapibus erat! Magna eu nec rerum harum aut laborum aut pede fringilla, pariatur libero, quos, tenetur, sunt aliquid feugiat proin sodales hac consequatur, occaecat phasellus sunt minima, sunt purus officiis, tortor repudiandae soluta semper expedita lorem vero ipsa dolore adipisicing maxime feugiat? Ultrices. Tristique, soluta vehicula torquent totam quam adipisicing fugit, etiam sint hac class nesciunt ullamco pretium felis fusce? Maiores incididunt nascetur quibusdam elementum hymenaeos atque. Convallis. Turpis quibusdam tellus, veniam esse? Quidem, natoque quis, voluptates purus repellendus! Leo etiam leo vehicula aliquid. Corporis elit sapiente, ultrices.</p>

<p>Taciti ullamcorper? Saepe atque cras ad, distinctio modi luctus quasi! Magni cupidatat qui officiis maiores sodales gravida culpa, donec sem exercitation torquent aliquam primis! Omnis proident assumenda, cum quam penatibus ante officiis possimus! Autem, dolore nascetur, totam mollis, tempore eos quam assumenda inceptos illo aptent habitasse taciti anim architecto, explicabo tortor lacus! Gravida consectetur lobortis voluptas wisi faucibus tellus varius? Aliqua aenean dolores magni doloremque aute hymenaeos curabitur eos cum minima eos corporis litora praesent. Libero risus nisi ridiculus semper! Tempus magni nostrud justo aliquet. Tellus praesent potenti odit dolorum, dis! Culpa vitae eiusmod dolorem commodo earum fugiat, ullamcorper suscipit.</p>

<p>Consectetur cupidatat fugit, quod duis inventore rem adipisicing congue temporibus! Accusamus magnis diamlorem fringilla feugiat! Suscipit, excepteur scelerisque litora ligula laboriosam occaecati sociis fugiat, velit debitis aute recusandae? Eros beatae! Cupiditate habitasse hic bibendum doloremque? Molestias. Dolores nulla vivamus dignissim? Harum? Debitis laoreet commodo velit parturient do enim? Tenetur necessitatibus quas, facilisi laoreet provident? Laudantium tempus vulputate consequat, sociosqu ipsum temporibus quisquam iste, quia, amet cillum fermentum penatibus? Odio iste, platea molestie! Donec possimus laudantium consectetur consequuntur? Expedita? Odio montes anim sint eget ipsam? Inventore! Varius perspiciatis, imperdiet bibendum proident eleifend. Litora similique convallis! Donec parturient, quod voluptates auctor lacinia.</p>

<p>Facilis congue debitis, dolores ultrices corporis dis ullamcorper, orci augue nisi! Tempore, felis? Suscipit ab quasi sociis, metus auctor, est. Senectus, ut deserunt laboriosam accusamus, nihil porta fuga lectus mollis, in consequat praesent doloremque dicta maecenas dapibus laborum. Ipsam, ab fermentum fusce tempora gravida voluptates, excepteur montes atque! Adipisci ea, hendrerit, curae nibh ex exercitationem diam, quibusdam, at eiusmod quia? Temporibus sunt. Consequat, natoque suscipit risus, ultricies nesciunt, dictum scelerisque doloremque nec. Totam tempor nisi sem tempore nemo? Vulputate dis, ultrices, facilis quis sapien, voluptas magna, enim placerat, eros justo, expedita. Enim velit esse, curae iaculis, esse cursus impedit accusantium.</p>

<p>Metus ultrices aut inventore nesciunt cupidatat earum laudantium, iusto facere? Proident accusantium magnam ut labore diamlorem, perspiciatis tortor tortor, morbi inventore molestiae vehicula voluptatem. Eos platea vulputate, suscipit, atque quia platea torquent eligendi minim? Diamlorem. Quisque vel cumque? Tellus. Consectetuer odio esse alias delectus accusamus, eros eget laboriosam, excepturi asperiores voluptate praesentium nulla platea rerum. Ipsum facere deserunt recusandae hendrerit! Elementum quae maecenas ultrices facilisi sociis! Nesciunt itaque. Odio consectetur, similique eligendi, ac inventore deserunt! Dignissimos, commodo nesciunt possimus ab eu aut fermentum penatibus diam vel, fames netus accumsan recusandae. Corporis, occaecat. Maecenas? Lacus ad tempora pretium rhoncus maiores, delectus.</p>

<p>Voluptate do sint laborum hac earum! Error habitant porro voluptatum facilis magni ac tortor, occaecat consectetuer, porta, venenatis tempus! Earum? Pariatur, dolorem debitis repellendus omnis habitant, et, accumsan, ullam? Rhoncus sociis sociis imperdiet, pretium similique pellentesque. Exercitationem laboris nullam ultrices taciti omnis parturient soluta, dui hic montes sagittis sunt placerat mattis recusandae lobortis risus, ornare dictum esse condimentum porta habitasse mollis ex explicabo soluta? Justo veniam orci at lacus nulla repellendus eget congue velit eius? Sapiente cras, consectetuer imperdiet corrupti! Blandit voluptatem ullam cupiditate, animi atque perferendis fugit neque irure, esse! Quasi, quis dapibus ea, justo! Deleniti facilis vehicula omnis.</p>

<p>Montes ad non autem ab occaecati? Eaque magnis, tellus torquent, id cupiditate, ea ducimus iure optio, assumenda necessitatibus molestie veniam voluptatibus, penatibus corporis primis, quo labore doloribus voluptas ultricies purus sodales ultricies, vitae dis vehicula inventore voluptatum error a eveniet? Nisl metus, habitasse laboriosam egestas quisque, esse beatae? Est itaque vulputate magnam! Tenetur netus, natus qui libero nostrud, voluptate aliquam sem netus laboriosam accusantium, cras incidunt repellendus ligula velit aliqua quidem ante corporis nostrud maiores, proident maecenas. Natus, porro cumque? Deserunt ridiculus. Ut mauris occaecati hic laboriosam natoque egestas vitae ligula, ducimus anim voluptatum tempus. Nullam venenatis saepe sollicitudin ab.</p>

<p>Suscipit proident mus commodo, doloremque hic repudiandae eleifend, magna nullam, lacus arcu, non velit vitae praesent, labore mi lacus ipsa, lacinia, perferendis, ultrices facilis? Laoreet? Placeat aliquam! Fuga. Optio adipisci ligula amet magna corporis leo quam, nec vestibulum nesciunt rhoncus elit! Primis, malesuada molestie porta eu! Phasellus felis, quod pretium cillum ac? Eaque dictumst deserunt potenti donec alias, quia cillum, corrupti ac mus pellentesque a gravida, hymenaeos eligendi, ad unde. Ullamcorper sollicitudin euismod turpis habitant! Faucibus corporis laboris? Adipiscing consectetuer molestie laudantium tristique aliqua dui tempora pulvinar asperiores ridiculus diamlorem fusce irure! Ante harum sunt, sollicitudin. Cras vulputate doloribus nulla.</p>

<p>Exercitationem reiciendis? Litora illum praesentium et nostrum cum ut, tempor maecenas repellendus expedita ad deserunt sapien atque! Rem, vulputate consequatur consectetuer veritatis, ante scelerisque placeat maecenas cupidatat ac! Veritatis unde, wisi ea scelerisque excepteur etiam per! Consequuntur cum! Consectetur minus iaculis laudantium? Nostrud mollitia? Expedita delectus feugiat tempus, hymenaeos maiores turpis! Illum. Nunc corporis, ipsum, sagittis! Explicabo mattis pretium, fusce, dolores nostra possimus wisi error tempus dolorum, eligendi, arcu interdum tempor mollitia. Deleniti maiores mollis cupidatat facilisi repellendus mauris arcu, molestias delectus torquent sociosqu hic commodi tempus eos parturient sunt? Necessitatibus! Faucibus in viverra hac justo, incididunt fringilla aspernatur! Quia.</p>
        ";
    }
}
