<?php

namespace ConsulConfigManager\Consul\Interfaces\Services;

use Consul\Exceptions\RequestException;

/**
 * Interface AccessControlListServiceInterface
 *
 * @package ConsulConfigManager\Consul\Interfaces\Services
 */
interface AccessControlListServiceInterface
{
    /**
     * This endpoint returns the status of the ACL replication processes in the datacenter.
     * This is intended to be used by operators or by automation checking to discover the health of ACL replication.
     *
     * @param string $datacenter Specifies the datacenter to query.
     *
     * @return array
     * @throws RequestException
     */
    public function replicationStatus(string $datacenter): array;

    /**
     * This endpoint translates the legacy rule syntax into the latest syntax.
     * It is intended to be used by operators managing Consul's ACLs and performing legacy token to new policy migrations.
     *
     * @param string $rule
     *
     * @throws RequestException
     *@return string
     */
    public function translateRule(string $rule): string;

    /**
     * This endpoint creates a new ACL token.
     * @param array $options
     *
     * @throws RequestException
     * @return array
     */
    public function createToken(array $options = []): array;

    /**
     * This endpoint reads an ACL token with the given Accessor ID.
     * @param string $accessorID
     *
     * @throws RequestException
     * @return array
     */
    public function readToken(string $accessorID): array;

    /**
     * This endpoint updates an existing ACL token.
     * @param string $accessorID
     * @param array  $options
     *
     * @throws RequestException
     * @return array
     */
    public function updateToken(string $accessorID, array $options = []): array;

    /**
     * This endpoint deletes an ACL token.
     * @param string $accessorID
     *
     * @throws RequestException
     * @return bool
     */
    public function deleteToken(string $accessorID): bool;

    /**
     * This endpoint returns the ACL token details that matches the secret ID specified with the X-Consul-Token
     * header or the token query parameter.
     *
     * @throws RequestException
     * @return array
     */
    public function myToken(): array;

    /**
     * This endpoint lists all the ACL tokens.
     * @param array $options
     *
     * @throws RequestException
     * @return array
     */
    public function listTokens(array $options = []): array;

    /**
     * This endpoint creates a new ACL role.
     * @param array $options
     *
     * @throws RequestException
     * @return array
     */
    public function createRole(array $options = []): array;

    /**
     * This endpoint reads an ACL role with the given ID.
     * If no role exists with the given ID, a 404 is returned instead of a 200 response.
     *
     * @param string $accessorID
     *
     * @throws RequestException
     * @return array
     */
    public function readRole(string $accessorID): array;

    /**
     * This endpoint reads an ACL role with the given name.
     * If no role exists with the given name, a 404 is returned instead of a 200 response.
     *
     * @param string $roleName
     *
     * @throws RequestException
     * @return array
     */
    public function readRoleByName(string $roleName): array;

    /**
     * This endpoint updates an existing ACL role.
     * @param string $accessorID
     * @param array  $options
     *
     * @throws RequestException
     * @return array
     */
    public function updateRole(string $accessorID, array $options = []): array;

    /**
     * This endpoint deletes an ACL role.
     * @param string $accessorID
     *
     * @throws RequestException
     * @return bool
     */
    public function deleteRole(string $accessorID): bool;

    /**
     * This endpoint lists all the ACL roles.
     * @param array $options
     *
     * @throws RequestException
     * @return array
     */
    public function listRoles(array $options = []): array;

    /**
     * This endpoint creates a new ACL policy.
     * @param array $options
     *
     * @throws RequestException
     * @return array
     */
    public function createPolicy(array $options = []): array;

    /**
     * This endpoint reads an ACL policy with the given ID.
     * @param string $accessorID
     *
     * @throws RequestException
     * @return array
     */
    public function readPolicy(string $accessorID): array;

    /**
     * This endpoint reads an ACL policy with the given Name.
     * @param string $policyName
     *
     * @throws RequestException
     * @return array
     */
    public function readPolicyByName(string $policyName): array;

    /**
     * This endpoint updates an existing ACL policy.
     * @param string $accessorID
     * @param array  $options
     *
     * @throws RequestException
     * @return array
     */
    public function updatePolicy(string $accessorID, array $options = []): array;

    /**
     * This endpoint deletes an ACL policy.
     * @param string $accessorID
     *
     * @throws RequestException
     * @return bool
     */
    public function deletePolicy(string $accessorID): bool;

    /**
     * This endpoint lists all the ACL policies.
     * @param array $options
     *
     * @throws RequestException
     * @return array
     */
    public function listPolicies(array $options = []): array;
}
