<?php

namespace RectorPrefix20211031;

if (\interface_exists('Tx_Extbase_Persistence_QueryInterface')) {
    return;
}
interface Tx_Extbase_Persistence_QueryInterface
{
}
\class_alias('Tx_Extbase_Persistence_QueryInterface', 'Tx_Extbase_Persistence_QueryInterface', \false);
