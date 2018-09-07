<?php
require_once 'config.php';

// require_once 'test/class/AgendaProduccionTest.php';

require_once 'test/ajax/ajaxAbrirPak.Test.php';

require_once 'test/class/cClientesGruposTest.php';

require_once 'test/class/cClientes.Test.php';

require_once 'test/class/cNroDocTest.php';

require_once 'test/class/cProductosTest.php';


// require_once 'test/php/cProductos.Test.php';

require_once 'test/php/ReporteProduccion_AjaxEliminar.Test.php';

require_once 'test/php/ReporteProduccion2.Test.php';

require_once 'test/lib/Fechas.Test.php';

require_once 'test/class/cOrden.Test.php';

// require_once 'test/class/testcReporteTirada.php';

/**
 * Static test suite.
 */
class distSuite extends PHPUnit\Framework\TestSuite
{

    /**
     * Constructs the test suite handler.
     */
    public function __construct()
    {
        // $this->setName('distSuite');

        // $this->addTestSuite('AgendaProduccionTest');

        $this->addTestSuite('ajaxAbrirPakTest');

        $this->addTestSuite('cClientesGruposTest');

        $this->addTestSuite('cClienteTest');
 
        $this->addTestSuite('cProductoTest');

        $this->addTestSuite('ReporteProduccion_AjaxEliminar_Test');

        $this->addTestSuite('ReporteProduccionTest');

        $this->addTestSuite('testFechas');

        // cambiar a la clase nueva
        // $this->addTestSuite('testOrden');

        // $this->addTestSuite('testReporteProduccion');
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}

