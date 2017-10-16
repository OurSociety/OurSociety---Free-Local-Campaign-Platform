SELECT
    source_key                         AS user_id,
    TIMESTAMP(changed->>"$.last_seen") AS last_seen,
    count(*)                           AS occurrences
FROM audits
WHERE
    changed->>"$.last_seen" IS NOT NULL
    AND source = 'users'
GROUP BY HOUR(last_seen)
ORDER BY last_seen DESC;
