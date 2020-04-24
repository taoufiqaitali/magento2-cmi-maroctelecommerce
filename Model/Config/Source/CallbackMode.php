<?php
namespace cmi\cmiecom\Model\Config\Source;

class CallbackMode implements \Magento\Framework\Option\ArrayInterface
{
 public function toOptionArray()
 {
  return [
    ['value' => '0', 'label' => __('Standard')],
    ['value' => '1', 'label' => __('API')]
  ];
 }
}
?>