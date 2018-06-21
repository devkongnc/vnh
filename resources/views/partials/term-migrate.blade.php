
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class {{ $data->class_name }} extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        {{ 'Schema::table("' . $data->table_name . '", function (Blueprint $table) {' }}
            <?php
            switch ($data->type) {
                case 'text':
                    echo '$table->string("' . $data->term_key . '");'; break;
                case 'single':
                    echo '$table->tinyInteger("' . $data->term_key . '")->unsigned();'; break;
                case 'multiple':
                    echo '$table->text("' . $data->term_key . '");'; break;
                default:
                    echo '$table->string("' . $data->term_key . '");'; break;
                    break;
            }
            ?>

        {{ '});' }}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        {{
        'Schema::table("' . $data->table_name . '", function (Blueprint $table) {
            $table->dropColumn("' . $data->term_key . '");
        });'
        }}
    }
}
