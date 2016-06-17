ALTER VIEW `v_balance_item` AS 
SELECT BI.`id`, BI.`order_num`, BI.`order_code`, BI.`name`, BI.`balance_type_id`, COUNT(ac.id) AS accounts_number
FROM `balance_item` AS BI
	LEFT OUTER JOIN account AS ac ON ac.balance_item_id = BI.id
GROUP BY BI.`id`, BI.`order_num`, BI.`order_code`, BI.`name`, BI.`balance_type_id`
ORDER BY order_code